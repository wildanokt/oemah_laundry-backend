<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

use Restserver\Libraries\REST_Controller;

class Peserta extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Peserta_model', 'peserta');
        $this->load->model('Event_model', 'event');
    }

    public function index_get()
    {
        $peserta = $this->peserta->getPeserta();

        if ($peserta) {
            $this->response([
                'status' => true,
                'data' => $peserta,
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'event tidak ditemukan / kosong',
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    //peserta daftar event
    public function index_post()
    {
        $id_event = $this->post('id_event');
        $event = $this->event->getEvent($id_event);
        $data = [
            'id_event' => $id_event,
            'nama' => $this->post('nama'),
            'email' => $this->post('email'),
            'alasan' => $this->post('alasan'),
            'konfirmasi' => 0,
            'kode_peserta' => $this->_generateKode(),
        ];

        $sisaKuota = $event[0]['kuota'] - ($this->event->getJumlahPeserta($id_event));
        if ($sisaKuota > 0) {
            if ($this->peserta->setPeserta($data) > 0) {
                $email = [
                    'nama' => $data['nama'],
                    'email' => $data['email'],
                    'subject' => 'Konfirmasi kedatangan pada event "' . strtoupper($event[0]['nama_event']) . '"',
                    'message' => '<!DOCTYPE html>
                    <html>
                        <body>
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout:fixed;background-color:#F9F9F9;" id="bodyTable">
                                <tr style="display: none !important; font-size: 1px; mso-hide: all;">
                                    <td></td>
                                </tr>
                                <tbody>
                                    <tr>
                                        <td align="center" valign="top" style="padding-right:10px;padding-left:10px;" id="bodyCell">
                                            <table border="0" cellpadding="0" cellspacing="0" style="max-width:600px; margin-top: 60px" width="100%" class="wrapperBody">
                                                <tbody>
                                                    <tr>
                                                        <td align="center" valign="top">
                                                            <table border="0" cellpadding="0" cellspacing="0" style="background-color:#FFFFFF;border-color:#E5E5E5; border-style:solid; border-width:0 1px 1px 1px;" width="100%" class="tableCard">
                                                                <tbody>
                                                                    <tr>
                                                                        <td height="3" style="background-color:#00384f;font-size:1px;line-height:3px;" class="topBorder">&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td align="center" valign="top" style="margin-top:100px;padding-top:50px;padding-bottom:5px;padding-left:20px;padding-right:20px;" class="mainTitle">
                                                                            <h2 class="text" style="color:#000000; font-family: Poppins, Helvetica, Arial, sans-serif; font-size:28px; font-weight:500; font-style:normal; letter-spacing:normal; line-height:36px; text-transform:none; text-align:center; padding:0; margin:0"> Kode Peserta : ' . $data['kode_peserta'] . '</h2>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td align="center" valign="top" style="padding-left:20px;padding-right:20px;" class="containtTable ui-sortable">
                                                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableDescription">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td align="center" valign="top" style="padding-bottom:20px;" class="description">
                                                                                            <p class="text" style="color:#666666; font-family: Open Sans, Helvetica, Arial, sans-serif; font-size:14px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:22px; text-transform:none; text-align:center; padding:0; margin:0">
                                                                                            Silakan kunjungi website kami melalui tombol dibawah untuk melakukan konfirmasi kehadiran dengan memasukkan kode peserta diatas 
                                                                                            </p>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="tableButton">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td align="center" valign="top" style="padding-top:20px;padding-bottom:20px;">
                                                                                            <table align="center" border="0" cellpadding="0" cellspacing="0">
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td align="center" class="ctaButton" style="background-color:#00384f;padding-top:12px;padding-bottom:12px;padding-left:35px;padding-right:35px;border-radius:50px"> <a class="text" href="https://google.com" target="_blank" style="color:#FFFFFF; font-family:Poppins, Helvetica, Arial, sans-serif; font-size:13px; font-weight:600; font-style:normal;letter-spacing:1px; line-height:20px; text-transform:uppercase; text-decoration:none; display:block"> KONFIRMASI KEHADIRAN </a>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td height="20" style="font-size:1px;line-height:1px;">&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td align="center" valign="middle" style="padding-bottom: 40px;" class="emailRegards"></td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="space">
                                                                <tbody>
                                                                    <tr>
                                                                        <td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table border="0" cellpadding="0" cellspacing="0" style="max-width:600px;" width="100%" class="wrapperFooter">
                                                <tbody>
                                                    <tr>
                                                        <td align="center" valign="top">
                                                            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="footer">
                                                                <tbody>
                                                                    <tr>
                                                                        <td align="center" valign="top" style="padding: 10px 10px 5px;" class="brandInfo">
                                                                            <p class="text" style="color:#777777; font-family:Open Sans, Helvetica, Arial, sans-serif; font-size:12px; font-weight:400; font-style:normal; letter-spacing:normal; line-height:20px; text-transform:none; text-align:center; padding:0; margin:0;">©&nbsp; Developer Student Club Universitas Brawijaya</p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td height="30" style="font-size:1px;line-height:1px;">&nbsp;</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                    </body>
                </html>',
                ];

                if ($this->_sendEmail($email)) {
                    $this->response([
                        'status' => true,
                        'message' => 'Pendaftaran berhasil dengan kode ' . $data['kode_peserta'],
                    ], REST_Controller::HTTP_CREATED);
                } else {
                    $this->response([
                        'status' => false,
                        'message' => $this->_sendEmail($email),
                    ], REST_Controller::HTTP_BAD_REQUEST);
                }
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'Pendaftaran gagal',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        } else {
            if ($sisaKuota <= 0) {
                $this->response([
                    'status' => false,
                    'message' => 'Pendaftaran gagal',
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }

    private function _generateKode($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private function _sendEmail($data)
    {
        $config = [
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_user' => 'dscbrawijaya@gmail.com',
            'smtp_pass' => '@dscubteam4',
            'smtp_port' => 465,
            'crlf'      => "\r\n",
            'newline'   => "\r\n"
        ];

        $this->load->library('email', $config);
        $this->email->from('dscbrawijaya@gmail.com', 'DSC Brawijaya');
        $this->email->to($data['email']);
        $this->email->subject($data['subject']);
        $this->email->message($data['message']);

        try {
            $this->email->send();
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
