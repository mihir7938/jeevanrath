<?php

namespace App\Services;

use App\Models\Account;

class AccountService
{

    public function getAllAccounts($per_page = -1)
    {
        if($per_page == -1){
            return Account::orderBy('created_at', 'desc')->get();    
        }
        return Account::orderBy('created_at', 'desc')->paginate($per_page);
    }

    public function getAccountById($id)
    {
        return Account::find($id);
    }

    public function create($data)
    {
        return Account::create($data);
    }

    public function update($accounts, $data)
    {
        return $accounts->update($data);
    }

    public function delete($accounts)
    {
        return $accounts->delete($accounts);
    }
}
