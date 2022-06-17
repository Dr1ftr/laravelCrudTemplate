<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountCreatedMailable extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected int $userId;
    protected string $activationCode;
    protected string $accountCreator;
    protected array $gottenRoles;

    /**
     * Create a new message instance.
     *
     * @param string $code that the recipient will use to activate their account (appended to the activate account link)
     * @param string $name who created the account
     * @param array $roles the roles that the user has gotten
     * @return void
     */
    public function __construct(int $userId, string $code, string $name, array $roles)
    {
        $this->subject("Account Created");
        
        $this->userId = $userId;
        $this->activationCode = $code;
        $this->accountCreator = $name;
        $this->gottenRoles = $roles;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        for ($i = 0; $i < count($this->gottenRoles); $i++) {
            $this->gottenRoles[$i] = // turn for example: super-user into Super User, or warehouse-admin into Warehouse Admin
                ucwords( // uppercase every first letter of each word
                    str_replace( // replace dashes with spaces
                        '-', ' ',
                        $this->gottenRoles[$i]['name']
                    )
                );
        }
        
        return $this->markdown('mail.activate-account', [
            "userId" => $this->userId,
            "code" => $this->activationCode,
            "name" => $this->accountCreator,
            "roles" => $this->gottenRoles
        ]);
    }
}
