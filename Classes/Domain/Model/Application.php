<?php
namespace Jokumer\Privacy\Domain\Model;

use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class Application
 * Area with personal data usage
 *
 * @package TYPO3
 * @subpackage tx_privacy
 * @author JKummer <service@enobe.de>
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Application
{
    /**
     * Key
     * Identifies entries from $GLOBALS[TYPO3_CONF_VARS][EXTCONF][privacy][applications]
     *
     * @var string
     */
    protected $key = '';

    /**
     * Fields to anonymize
     * Contains field names from $GLOBALS[TYPO3_CONF_VARS][EXTCONF][privacy][applications][*][fieldProcessing][anonymize]
     *
     * @var array
     */
    protected $fieldsToAnonymize = [];

    /**
     * Fields to export
     * Contains field names from $GLOBALS[TYPO3_CONF_VARS][EXTCONF][privacy][applications][*][fieldProcessing][export]
     *
     * @var array
     */
    protected $fieldsToExport = [];

    /**
     * Icon
     *
     * @var string
     */
    protected $icon = '';

    /**
     * Label
     * 
     * @var string
     */
    protected $label = '';

    /**
     * SubjectsTotal
     *
     * @var int
     */
    protected $subjectsTotal = 0;

    /**
     * Table
     *
     * @var string
     */
    protected $table = '';

    /**
     * Setter for icon
     *
     * @param string $icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    /**
     * Getter for icon
     *
     * @return string
     */
    public function getIcon()
    {
        /** @var IconFactory $iconFactory */
        $iconFactory = GeneralUtility::makeInstance(IconFactory::class);
        $icon = $iconFactory->getIconForRecord($this->table, [])->getIdentifier();
        return $icon;
    }

    /**
     * Setter for fields to anonymize
     *
     * @param array $fieldsToAnonymize
     */
    public function setFieldsToAnonymize($fieldsToAnonymize)
    {
        $this->fieldsToAnonymize = $fieldsToAnonymize;
    }

    /**
     * Getter for fields to anonymize
     *
     * @return array
     */
    public function getFieldsToAnonymize()
    {
        return $this->fieldsToAnonymize;
    }

    /**
     * Setter for fields to export
     *
     * @param array $fieldsToExport
     */
    public function setFieldsToExport($fieldsToExport)
    {
        $this->fieldsToExport = $fieldsToExport;
    }

    /**
     * Getter for fields to export
     *
     * @return array
     */
    public function getFieldsToExport()
    {
        return $this->fieldsToExport;
    }

    /**
     * Setter for key
     *
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * Getter for key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Setter for label
     *
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * Getter for label
     *
     * @return string
     */
    public function getLabel()
    {
        if (substr($this->label, 0, 4) === 'LLL:') {
            return htmlspecialchars($this->getLanguageService()->sL($this->label));
        } else {
            return htmlspecialchars($this->label ? $this->label : $this->table);
        }
    }

    /**
     * Setter for subjectsTotal
     *
     * @param string $subjectsTotal
     */
    public function setSubjectsTotal($subjectsTotal)
    {
        $this->subjectsTotal = $subjectsTotal;
    }

    /**
     * Getter for subjectsTotal
     *
     * @return string
     */
    public function getSubjectsTotal()
    {
        return $this->subjectsTotal;
    }

    /**
     * Setter for table
     *
     * @param string $table
     */
    public function setTable($table)
    {
        $this->table = $table;
    }

    /**
     * Getter for table
     *
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Returns LanguageService
     *
     * @return \TYPO3\CMS\Lang\LanguageService
     */
    protected function getLanguageService()
    {
        return $GLOBALS['LANG'];
    }
}
