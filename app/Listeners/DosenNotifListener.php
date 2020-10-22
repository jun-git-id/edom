<?php

namespace App\Listeners;

use App\Mail\DosenNotifMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class DosenNotifListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {

        $dosen = $event->data['dosen'];
        $tak_id = $event->data['tak_id'];

        $jml_mhs_mengisi = DB::select(DB::raw("
        SELECT
            count(fill.mahasiswa_id) as jml
        FROM
            teaches te, fillings fill
        WHERE
            fill.mengajar_id = te.id
            and te.dosen_id = $dosen->id
            and te.tahun_akademik_id = $tak_id;
        "))[0]->jml;

        $jml_mhs = DB::select(DB::raw("
        SELECT
            count(mhs.id) as jml
        FROM
            students mhs, classes kls, teaches te
        WHERE
            te.kelas_id = kls.id
            and mhs.kelas_id = kls.id
            and te.dosen_id = $dosen->id
            and te.tahun_akademik_id = $tak_id;
        "))[0]->jml;


        //dd($dosen->user->email);
        //dd($jml_mhs);
        if ((int)$jml_mhs_mengisi == (int)$jml_mhs) {
            $email = $dosen->user->email;
            $email = implode('', explode(' ', $email));

            Mail::to($email)->send(new DosenNotifMail($dosen->nama));
        }


        //echo $event->data . 'dosen';
    }
}
