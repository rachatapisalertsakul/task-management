<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProjectNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name_project, $desciption_project)
    {
        //เราสามารถส่ง Parameter มาจากที่อื่นได้โดยใช้ Constructor รับค่า
        $this->name_project = $name_project;
        $this->desciption_project = $desciption_project;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //เวลาใช้งานดึงการแสดงผลจาก View เหมือนกับ Controller ทั่วไป
        $name_project = $this->name_project;
        $desciption_project = $this->desciption_project;


        return $this->subject('คุณถูกเพิ่มเข้า Project ใหม่ในระบบ Task Management System !')->view('Mail.ProjectNotificationMail', compact('name_project', 'desciption_project'));
    }
}
