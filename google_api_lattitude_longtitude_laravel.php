<?php


$cityList= $this->placeModel->latlog();


        foreach ($cityList as $city) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "http://maps.googleapis.com/maps/api/geocode/json?address=$city->name&sensor=false",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "Cache-Control: no-cache",
                    "Postman-Token: 292a30e9-8c5a-4efd-9367-a6bac36a40ed"
                ),
            ));

            $response = json_decode(curl_exec($curl));
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err; die;
            } else {


                if(isset($response->status) && $response->status== "OK"){
                var_dump($response->results[0]);

                echo '<br><br><br><br>';
                    $latLng = $response->results[0]->geometry->location;

                    $geolocation =$latLng->lat.','. $latLng->lng;

                    $data = array(
                       'geo_location'=>$geolocation
                 );
                    $this->placeModel->InsertCity($data,$city->city_id) ;
                }else{

                    echo 'Fail Cities'.$city->name.' /';
                }
            }
        }
		
		
		?>