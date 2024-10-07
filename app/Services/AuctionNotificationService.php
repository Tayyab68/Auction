<?php

namespace App\Services;

use App\Models\Auction;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class AuctionNotificationService
{
    public function notifyParticipants(Auction $auction, $subject, $message)
    {
        $participants = $auction->bids()->with('user')->get()->pluck('user');

        foreach ($participants as $participant) {
            $this->sendEmail($participant, $subject, $message);
        }
    }

    public function notifyWinner(User $winner, Auction $auction)
    {
        $subject = 'Congratulations! You have won the auction';
        $message = 'You are the highest bidder for the auction: ' . $auction->item->name;
        $this->sendEmail($winner, $subject, $message);
    }

    protected function sendEmail(User $user, $subject, $message)
    {
        Mail::raw($message, function ($mail) use ($user, $subject) {
            $mail->to($user->email)
                 ->subject($subject);
        });
    }
}
