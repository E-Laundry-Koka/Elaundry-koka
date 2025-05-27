<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $pesanan;
    public $totalHarga;
    public $layanan;

    protected $pdfPath;

    public function __construct($pesanan, $totalHarga, $layanan, $pdfPath)
    {
        $this->pesanan = $pesanan;
        $this->totalHarga = $totalHarga;
        $this->layanan = $layanan;
        $this->pdfPath = $pdfPath;
    }

    public function build()
    {
        return $this->view('emails.order_created')
                    ->subject('Detail Pesanan #' . $this->pesanan->id)
                    ->attach($this->pdfPath, [
                        'as' => 'detail_pesanan_' . $this->pesanan->id . '.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
}
