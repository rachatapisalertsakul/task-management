<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MeetingNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $link, $description, $date_start)
    {
        //เราสามารถส่ง Parameter มาจากที่อื่นได้โดยใช้ Constructor รับค่า
        $this->title = $title;
        $this->link = $link;
        $this->description = $description;
        $this->date_start = $date_start;
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
        $link = $this->link;
        $description = $this->description;
        $date_start = DateThai($this->date_start);

        return $this->subject('คุณมี Meeting ใหม่ในระบบ Task Management System !')->view('Mail.MeetingNotificationMail', compact('title','link','description', 'date_start'));
    }
}
