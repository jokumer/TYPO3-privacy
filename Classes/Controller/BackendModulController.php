<?php
namespace Jokumer\Privacy\Controller;

use Jokumer\Privacy\Domain\Model\Application;
use Jokumer\Privacy\Domain\Repository\ApplicationRepository;
use Jokumer\Privacy\Domain\Repository\SubjectRepository;
use TYPO3\CMS\Backend\Template\Components\ButtonBar;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\Utility\BackendUtility;
use TYPO3\CMS\Backend\View\BackendTemplateView;
use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\Utility\CsvUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Lang\LanguageService;

/**
 * Class BackendModulController
 *
 * @package TYPO3
 * @subpackage tx_privacy
 * @author JKummer <service@enobe.de>
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class BackendModulController extends ActionController
{
    /**
     * Default view object name
     * 
     * @var string
     */
    protected $defaultViewObjectName = BackendTemplateView::class;

    /**
     * View
     * 
     * @var BackendTemplateView
     */
    protected $view;

    /**
     * Application repository
     * 
     * @var ApplicationRepository
     */
    protected $applicationRepository;

    /**
     * Subject repository
     *
     * @var SubjectRepository
     */
    protected $subjectRepository;

    /**
     * Inject application repository
     * 
     * @param ApplicationRepository $applicationRepository
     */
    public function injectApplicationRepository(ApplicationRepository $applicationRepository)
    {
        $this->applicationRepository = $applicationRepository;
    }

    /**
     * Inject subject repository
     *
     * @param SubjectRepository $subjectRepository
     */
    public function injectSubjectRepository(SubjectRepository $subjectRepository)
    {
        $this->subjectRepository = $subjectRepository;
    }

    /**
     * Set up the doc header properly here
     *
     * @param ViewInterface $view
     */
    protected function initializeView(ViewInterface $view)
    {
        /** @var BackendTemplateView $view */
        parent::initializeView($view);
        $this->registerDocHeaderButtons();
        $this->view->assign('returnUrl', rawurlencode(\TYPO3\CMS\Core\Utility\GeneralUtility::getIndpEnv('REQUEST_URI')));
    }

    /**
     * Main method for backend modul - lists registered applications
     */
    public function listApplicationsAction()
    {
        $applications = $this->applicationRepository->getApplications();
        $this->view->assign('applications', $applications);
    }

    /**
     * List subjects from selected application
     * 
     * @param string $applicationKey
     */
    public function listSubjectsAction($applicationKey = null)
    {
        $application = null;
        $subjects = null;
        if ($applicationKey !== null) {
            $application = $this->applicationRepository->getApplication($applicationKey);
            $subjects = $this->applicationRepository->getApplicationSubjects($applicationKey);
        }
        $this->view->assign('application', $application);
        $this->view->assign('subjects', $subjects);
        $this->view->assign('tceDbModuleUrl', BackendUtility::getModuleUrl('tce_db'));
    }

    /**
     * Anonymize subject
     * Needs applicationKey and subjectUid as request parameters
     */
    public function anonymizeSubjectAction() {
        // Get application
        $application = null;
        if ($this->request->hasArgument('applicationKey')) {
            /** @var Application $application */
            $application = $this->applicationRepository->getApplication($this->request->getArgument('applicationKey'));
        }
        // Get fields to anonymize
        $fieldsToAnonymize = null;
        if ($application instanceof Application) {
            $fieldsToAnonymize = $application->getFieldsToAnonymize();
        }
        // Get subject
        $subject = null;
        if ($application instanceof Application && $this->request->hasArgument('subjectUid')) {
            $subject = $this->subjectRepository->getSubject((string)$application->getTable(), (int)$this->request->getArgument('subjectUid'));
        }
        // Update subject for fields to anonymize
        if (!empty($subject) && !empty($fieldsToAnonymize)) {
            foreach ($fieldsToAnonymize as $fieldToAnonymize) {
                $updateFields[$fieldToAnonymize] = 0; // @todo: do real anonymization depend on DB field properties
            }
            $this->subjectRepository->updateSubject($application->getTable(), $subject['uid'], $updateFields);
            $this->redirect('listSubjects', null, null, ['applicationKey' => $application->getKey()]);
        }
    }

    /**
     * Export subject
     * Needs applicationKey and subjectUid as request parameters
     */
    public function exportSubjectAction() {
        // Get application
        $application = null;
        if ($this->request->hasArgument('applicationKey')) {
            /** @var Application $application */
            $application = $this->applicationRepository->getApplication($this->request->getArgument('applicationKey'));
        }
        // Get fields to export
        $fieldsToExport = null;
        if ($application instanceof Application) {
            $fieldsToExport = $application->getFieldsToExport();
        }
        // Get subject
        $subject = null;
        if ($application instanceof Application && $this->request->hasArgument('subjectUid')) {
            $subject = $this->subjectRepository->getSubject((string)$application->getTable(), (int)$this->request->getArgument('subjectUid'));
        }
        // Get subject for fields to export
        if (!empty($subject) && !empty($fieldsToExport)) {
            // Get csv data
            $csvData = [];
            $exportKeys = [];
            $exportValues = [];
            foreach ($fieldsToExport as $fieldToExport) {
                $exportKeys[$fieldToExport] = $fieldToExport; // @todo: use LLL labels for field keys
                $exportValues[$fieldToExport] = isset($subject[$fieldToExport]) ? $subject[$fieldToExport] : ''; 
            }
            $delim = ','; // @todo: configurable delimeter
            $quote = '"'; // @todo: configurable quote
            $csvData['keys'] = CsvUtility::csvValues($exportKeys, $delim, $quote); // @todo: compatibility TYPO3 < 8.7 GeneralUtility::csvValues()
            $csvData['values'] = CsvUtility::csvValues($exportValues, $delim, $quote); // @todo: compatibility: TYPO3 < 8.7 GeneralUtility::csvValues()
            // Provide download
            $filename = 'TYPO3_' . $application->getKey() . '_' . $subject['uid'] . '_' . date('dmYHi') . '.csv'; // @todo: configurable filename
            $mimeType = 'application/octet-stream';
            header('Content-Type: ' . $mimeType);
            header('Content-Disposition: attachment; filename=' . $filename);
            echo implode(CRLF, $csvData);
            die;
        } else {
            // @todo: error handling
            $this->redirect('listSubjects', null, null, ['applicationKey' => $application->getKey()]);
        }
    }

    /**
     * Registers the Icons into the doc header
     *
     * @throws \InvalidArgumentException
     */
    protected function registerDocHeaderButtons()
    {
        if ($this->view->getModuleTemplate() instanceof ModuleTemplate) {
            /** @var ButtonBar $buttonBar */
            $buttonBar = $this->view->getModuleTemplate()->getDocHeaderComponent()->getButtonBar();
            // Add shortcut button
            $this->addDocHeaderButtonShortcut($buttonBar);
        }
    }

    /**
     * Add docheader button for shortcut
     * 
     * @param ButtonBar $buttonBar
     */
    protected function addDocHeaderButtonShortcut(ButtonBar $buttonBar)
    {
        $mayMakeShortcut = $this->getBackendUser()->mayMakeShortcut();
        if ($mayMakeShortcut) {
            $moduleName = $this->request->getPluginName();
            $extensionName = $this->request->getControllerExtensionName();
            $getVars = $this->request->getArguments();
            if (count($getVars) === 0) {
                $modulePrefix = strtolower('tx_' . $extensionName . '_' . $moduleName);
                $getVars = ['id', 'M', $modulePrefix];
            }
            $shortcutButton = $buttonBar->makeShortcutButton()
                ->setModuleName($moduleName)
                ->setDisplayName($this->getLanguageService()->sL('LLL:EXT:privacy/Resources/Private/Language/locallang.xlf:module.shortcut.name'))
                ->setGetVariables($getVars);
            $buttonBar->addButton($shortcutButton);
        }
    }

    /**
     * Returns the current BE user.
     *
     * @return BackendUserAuthentication
     */
    protected function getBackendUser(): BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }

    /**
     * Returns the Language Service
     *
     * @return LanguageService
     */
    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}
