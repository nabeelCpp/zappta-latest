<?php

namespace App\Controllers;

use \DrewM\MailChimp\MailChimp;
use GuzzleHttp\Client;

class Mailchimps extends BaseController
{
    public function index()
    {
        $email_address = trim(strip_tags($this->request->getVar('subscribeemail')));
        if ( empty($email_address) || $email_address == "" || !valid_email($email_address) ) {
                return json_encode( [ 'code' => 1 , 'title' => '', 'detail' => 'Please enter valid email', 'token' => csrf_hash() ] );
        } else {
            // $client = new Klaviyo('pk_5f6d21eb12c850fe87465387a9591f5a2b','SYVhLF');
            // $MailChimp = new MailChimp('822bdb5d4619b3c1b728b14944951c02-us14');
            // $list_id = '3b72667860';
            // $result = $MailChimp->post("lists/$list_id/members", [
            //                 'email_address' => $email_address,
            //                 'status'        => 'subscribed',
            //             ]);
            // if ( $result['status'] == 400 ) {
            //     return json_encode( [ 'code' => 1 , 'title' => $result['title'], 'detail' => $result['detail'] ] );
            // } elseif( $result['status'] == 'subscribed' ) {
            //     return json_encode( [ 'code' => 2 , 'title' => '', 'detail' => 'Email successfully subscribed' ] );
            // } else {
            //     return json_encode( [ 'code' => 1 , 'title' => $result['title'], 'detail' => $result['detail'] ] );
            // }
            $client = new Client();
            $response = $client->request('POST', 'https://a.klaviyo.com/api/v2/list/WjThKt/subscribe?api_key=pk_5f6d21eb12c850fe87465387a9591f5a2b', [
              'body' => '{"profiles":[{"email":"'.$email_address.'"}]}',
              'headers' => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
              ],
            ]);
            $r = json_decode($response->getBody());
            if ( is_array($r) && count($r) > 0 && $r[0]->id != '' ) {
                return json_encode( [ 'code' => 2 , 'title' => '', 'detail' => 'Email successfully subscribed', 'token' => csrf_hash() ] );
            } else {
                return json_encode( [ 'code' => 1 , 'title' => 'Error', 'detail' => 'Email failed to subscribed', 'token' => csrf_hash() ] );
            }
        }
        // print '<pre>';
        // print_r($result['title']);
        // print '</pre>';
    }

    // public function getlist()
    // {
    //     // $client = new Client('pk_5f6d21eb12c850fe87465387a9591f5a2b');
    //     $client = new Client();
    //     $response = $client->request('POST', 'https://a.klaviyo.com/api/v2/list/WjThKt/subscribe?api_key=pk_5f6d21eb12c850fe87465387a9591f5a2b', [
    //       'body' => '{"profiles":[{"email":"george.washingtonssss@klaviyo.com"}]}',
    //       'headers' => [
    //         'Accept' => 'application/json',
    //         'Content-Type' => 'application/json',
    //       ],
    //     ]);
    //     // $response = $client->request('GET', 'https://a.klaviyo.com/api/v2/lists?api_key=pk_5f6d21eb12c850fe87465387a9591f5a2b', [
    //     //   'headers' => [
    //     //     'Accept' => 'application/json',
    //     //   ],
    //     // ]);
    //     $r = json_decode($response->getBody());
    //     if ( is_array($r) && count($r) > 0 && $r[0]->id != '' ) {
    //         print $r[0]->id;
    //     } else {
    //         print 'Email failed to subscribed';
    //     }
    //     die();
    //     print '<pre>';
    //     print_r(json_decode($response->getBody()));
    //     print '</pre>';
    // }

}
