<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RejectNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $note)
    {
        //เราสามารถส่ง Parameter มาจากที่อื่นได้โดยใช้ Constructor รับค่า
        $this->title = $title;
        $this->note = $note;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //เวลาใช้งานดึงการแสดงผลจาก View เหมือนกับ Controller ทั่วไป
        $title = $this->title;
        $note = $this->note;

        return $this->subject('Task ของคุณถูก Reject ในระบบ Task Management System !')->view('Mail.RejectNotificationMail', compact('title','note'));
    }
}
