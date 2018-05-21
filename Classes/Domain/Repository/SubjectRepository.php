<?php
namespace Jokumer\Privacy\Domain\Repository;

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

/**
 * Class SubjectRepository
 * Provides methods to fetch/update subjects for any application
 *
 * @package TYPO3
 * @subpackage tx_privacy
 * @author JKummer <service@enobe.de>
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class SubjectRepository
{
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
     * Get all subjects for an application by table
     *
     * @param string $table
     * @return array $subjects
     */
    public function getSubjects($table = null)
    {
        $subjects = [];
        if ($table !== null) {
            /** @var ConnectionPool $queryBuilder */
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getQueryBuilderForTable($table);
            $subjects = (array)$queryBuilder->select('*')
                ->from($table)
                ->execute()
                ->fetchAll();
        }
        return $subjects;
    }

    /**
     * Count all subjects for an application by table
     *
     * @param string $table
     * @return int $count
     */
    public function countSubjects($table = null)
    {
        $count = 0;
        if ($table !== null) {
            /** @var ConnectionPool $queryBuilder */
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getQueryBuilderForTable($table);
            $count = (int)$queryBuilder->count('uid')
                ->from($table)
                ->execute()
                ->fetchColumn();
        }
        return $count;
    }

    /**
     * Get a single subject for an application by table and uid
     *
     * @param string $table
     * @param int $uid
     * @return array|null $subjects
     */
    public function getSubject($table = null, $uid = null)
    {
        $subject = null;
        if ($table !== null && $uid !== null) {
            /** @var ConnectionPool $queryBuilder */
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getQueryBuilderForTable($table);
            $subject = (array)$queryBuilder->select('*')
                ->from($table)
                ->where(
                    $queryBuilder->expr()->eq(
                        'uid',
                        $queryBuilder->createNamedParameter((int)$uid, \PDO::PARAM_INT)
                    )
                )
                ->execute()
                ->fetch();
        }
        return $subject;
    }

    /**
     * Update a single subject for an application by table and uid
     *
     * @param string $table
     * @param int $uid
     * @param array $updateFields
     * @return void
     */
    public function updateSubject($table = null, $uid = null, array $updateFields)
    {
        if ($table !== null && $uid !== null && !empty($updateFields)) {
            /** @var ConnectionPool $queryBuilder */
            GeneralUtility::makeInstance(ConnectionPool::class)
                ->getConnectionForTable($table)
                ->update($table, $updateFields, ['uid' => (int)$uid]);
        }
    }

    /**
     * Delete a single subject for an application by table and uid
     *
     * @param string $table
     * @param int $uid
     * @return void
     */
    public function deleteSubject($table = null, $uid = null)
    {
        if ($table !== null && $uid !== null) {
            /** @var ConnectionPool $queryBuilder */
            GeneralUtility::makeInstance(ConnectionPool::class)
                ->getConnectionForTable($table)
                ->delete($table, ['uid' => (int)$uid]);
        }
    }
}
