<?php
namespace SpyderText\Account;

use SpyderText\BaseSDK;
use SpyderText\Base\Component\Collection;
use SpyderText\Base\Exception\BaseException;
use SpyderText\Program\Exception\{
    ProgramCollectionException,
    ProgramException
};

class ProgramSDK extends BaseSDK
{
    public function collection(array $filters = []) : Collection
    {
        $safeFilters = [
            'q'           => array_key_exists('q', $filters) ? $filters['q'] : null,
            'page'        => array_key_exists('page', $filters) ? $filters['page'] : null,
        ];

        try {
            $result = $this->_get('/api/v/1/program', $safeFilters);
        } catch(BaseException $ex) {
            throw new ProgramCollectionException("Failed get account collection: " . $ex->getMessage());
        }

        return new Collection($result, $this);
    }

    public function addParticipant(int $programId, int $accountId)
    {
        try {
            return $this->_post('/api/v/1/program/{programId}/participant/{accountId}', [
                'programId' => $programId,
                'accountId' => $accountId,
            ]);
        } catch(BaseException $ex) {
            throw new ProgramException("Failed to put ");
        }
    }
}