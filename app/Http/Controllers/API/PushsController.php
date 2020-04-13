<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PushsController extends Controller
{
    public function pushSend(Request $request)
    {
        try
        {

            set_time_limit(0);

            $objPush = $request->all();
            $strKey = $request->header('Authorization');

            $arrVip = ['f4015aa2-783f-11ea-bc55-0242ac130003'];

            if(in_array($strKey, $arrVip)):

                if(count($objPush['tokenId']) == 0):
                    $data['message'] = utf8_encode('Você precisa passar os tokens para enviar!');
                    $data['line'] = 0;
                    $data['error'] = 1;
                    return response()->json($data, 400);
                endif;


		        $fields = array
		        (
		            'registration_ids'  => $objPush['tokenId'],
			        'notification'      => $objPush['notification'],
		            'priority'          => $objPush['priority']
		        );

                $message['message'] = $fields;

		        $headers = array
		        (
		            'Authorization:key=<TOKEN FIREBASE>',// TODO: CRIAR TELA DE CADASTRO DE CIDADE/TOKEN
		            'Content-Type:application/json'
		        );

		        $ch = curl_init();
		        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
		        curl_setopt( $ch,CURLOPT_POST, true );
		        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
		        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
		        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
		        $result = curl_exec($ch );
		        curl_close( $ch );
                $objJsonError = json_decode($result);

                for($i=0;$i<count($objPush['tokenId']);$i++):

                    $arrResultIds[$i]['token'] = $objPush['tokenId'][$i];
                    $arrResultIds[$i]['success'] = (isset($objJsonError->results[$i]->error) ? 0:1);
                    $arrResultIds[$i]['fcm_return'] = (isset($objJsonError->results[$i]->error) ? $objJsonError->results[$i]->error:$objJsonError->results[$i]->message_id);

                endfor;

                return response()->json($arrResultIds, 200);
            else:
                $data['message'] = utf8_encode('Token não inválido!');
                $data['line'] = 0;
                $data['error'] = 1;
                return response()->json($data, 400);
            endif;
        }
        catch( \Exception $e ){
            $data['status'] = 'BAD_REQUEST';
            $data['message'] = $e->getMessage();
            $data['line'] = $e->getLine();
            $data['error'] = $e->getMessage();
            return response()->json($data, 400);
        }
    }
}
