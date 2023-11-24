<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TaskNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $note, $name_project)
    {
        //เราสามารถส่ง Parameter มาจากที่อื่นได้โดยใช้ Constructor รับค่า
        $this->title = $title;
        $this->note = $note;
        $this->name_project = $name_project;
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
        $name_project = $this->name_project;

        return $this->subject('คุณได้รับ Task ใหม่ในระบบ Task Management System !')->view('Mail.TaskNotificationMail', compact('title','note','name_project'));
    }
}
