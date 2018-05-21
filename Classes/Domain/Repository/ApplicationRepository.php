<?php
namespace Jokumer\Privacy\Domain\Repository;

use Jokumer\Privacy\Domain\Model\Application;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManager;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * Class ApplicationRepository
 * Provides methods to fetch applications which contains data subjects with privacy requirements.
 * Applications are configured in typoscript module.tx_privacy.settings.applications
 *
 * @package TYPO3
 * @subpackage tx_privacy
 * @author JKummer <service@enobe.de>
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ApplicationRepository
{
    /**
     * Configured applications
     *
     * @var array
     */
    protected $configuredApplications = [];

    /**
     * Object manager interface
     * 
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * Inject ObjectManager
     * 
     * @param ObjectManagerInterface $objectManager
     */
    public function injectObjectManager(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Constructor of the application repository
     */
    public function __construct()
    {
        /** @var ConfigurationManager $configurationManager */
        $configurationManager = GeneralUtility::makeInstance(ConfigurationManager::class);
        $configuration = $configurationManager->getConfiguration(ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS, 'privacy');
        if (isset($configuration['applications'])) {
            $this->configuredApplications = $configuration['applications'];
        }
    }

    /**
     * Get all application objects
     *
     * @return array $applications
     */
    public function getApplications()
    {
        $applications = [];
        if (!empty($this->configuredApplications)) {
            foreach ($this->configuredApplications as $applicationKey => $applicationConfiguration) {
                $applications[] = $this->getApplication($applicationKey);
            }
        }
        return $applications;
    }

    /**
     * Get single application object
     *
     * @param string $applicationKey
     * @return Application|null $application
     */
    public function getApplication($applicationKey = null)
    {
        $application = null;
        if ($applicationKey !== null && isset($this->configuredApplications[$applicationKey])) {
            $applicationConfiguration = $this->configuredApplications[$applicationKey];
            $application = $this->objectManager->get(Application::class);
            // Set properties
            $application->setKey($applicationKey);
            if (isset($applicationConfiguration['table'])) {
                $application->setTable($applicationConfiguration['table']);
            }
            if (isset($applicationConfiguration['fieldProcessing']['anonymize'])) {
                $application->setFieldsToAnonymize($applicationConfiguration['fieldProcessing']['anonymize']);
            }
            if (isset($applicationConfiguration['fieldProcessing']['export'])) {
                $application->setFieldsToExport($applicationConfiguration['fieldProcessing']['export']);
            }
            if (isset($applicationConfiguration['label'])) {
                $application->setLabel($applicationConfiguration['label']);
            }
            $application->setSubjectsTotal($this->countApplicationSubjects($applicationKey));
        }
        return $application;
    }

    /**
     * Get subjects from a single application by application key
     *
     * @param string $applicationKey
     * @return mixed
     */
    public function getApplicationSubjects($applicationKey = null)
    {
        $applicationSubjects = null;
        if ($applicationKey !== null) {
            if (isset($this->configuredApplications[$applicationKey]['table'])) {
                /** @var SubjectRepository $subjectRepository */
                $subjectRepository = $this->objectManager->get(SubjectRepository::class);
                $applicationSubjects = $subjectRepository->getSubjects($this->configuredApplications[$applicationKey]['table']);
            }
        }
        return $applicationSubjects;
    }

    /**
     * Count subjects from a single application by application key
     *
     * @param string $applicationKey
     * @return mixed
     */
    public function countApplicationSubjects($applicationKey = null)
    {
        $countApplicationSubjects = null;
        if ($applicationKey !== null) {
            if (isset($this->configuredApplications[$applicationKey]['table'])) {
                /** @var SubjectRepository $subjectRepository */
                $subjectRepository = $this->objectManager->get(SubjectRepository::class);
                $countApplicationSubjects = $subjectRepository->countSubjects($this->configuredApplications[$applicationKey]['table']);
            }
        }
        return $countApplicationSubjects;
    }
}
