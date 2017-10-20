<?php
namespace SpyderText\Account;

use SpyderText\BaseSDK;
use SpyderText\Base\Component\Collection;
use SpyderText\Base\Exception\BaseException;
use SpyderText\Account\Exception\{
    AccountCollectionException,
    AccountException,
    SaveAccountException
};

class AccountSDK extends BaseSDK
{
    public function get(int $accountId)
    {
        try {
            
            return $this->_get('/api/v/1/account/{accountId}', [
                'accountId' => $accountId,
            ]);

        } catch(BaseException $ex) {
            throw new AccountException("Failed to get account: " . $ex->getMessage());
        }
    }

    public function delete(int $accountId)
    {
        try {
            
            return $this->_delete('/api/v/1/account/{accountId}', [
                'accountId' => $accountId,
            ]);

        } catch(BaseException $ex) {
            throw new AccountException("Failed to delete account: " . $ex->getMessage());
        }
    }

    public function create(array $data = []) : array
    {
        try {
            
            $result = $this->_post('/api/v/1/account', array_merge([
                'photo' => null,
                'active' => true,
                'group_ids' => [],
                'extended_attributes' => []
            ], $data));

        } catch(BaseException $ex) {
            throw new SaveAccountException("Failed to save account: " . $ex->getMessage());
        }

        return $result;
    }

    public function collection(array $filters = []) : Collection
    {
        $safeFilters = [
            'account_ids' => array_key_exists('account_ids', $filters) ? $filters['account_ids'] : null,
            'q'           => array_key_exists('q', $filters) ? $filters['q'] : null,
            'page'        => array_key_exists('page', $filters) ? $filters['page'] : null,
        ];

        try {
            $result = $this->_get('/api/v/1/account', $safeFilters);
        } catch(BaseException $ex) {
            throw new AccountCollectionException("Failed get account collection: " . $ex->getMessage());
        }

        return new Collection($result, $this);
    }
}