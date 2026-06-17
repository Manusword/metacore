<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ai extends CI_Controller {

	function __construct() 
	{
        parent::__construct();
		$this->load->model('Base');		
	}//function close


	public function index()
	{
		redirect("welcome/");
	}//function close

  
    
    // Function to handle /ask endpoint
    public function ask($aidata,$dataname,$question,$previousResponse, $feedback = null) 
    {
        //$intro = "My compnay name is RKS Steel Industries Pvt Ltd. leading manufacturer in North India for High and low Carbon(Black and galvanized and Fine & Thick), RQ/FQ (Black & Galvanized), Mild Steel and other type of steel wires in various sizes and grades. We also manufacture Wire Ropes, Inner Wire / Strand for Control Cables. I am providing JSON data. If there are any numbers within this data, please treat them as numerical values. And here is my question: ";
        $intro = " ";
        $question = $intro.$question. " .I need data and a brief explanation. Please provide the response using HTML tags and CSS, which I can then paste directly into an HTML page to display. If in the response, the date should be in DD-MM-YYYY format. Don't show any script. ";
        
       
        //variable
        $paraArray = array();
        $productionData = ""; // In-memory storage for production data
        $GEMINI_API_KEY = "AIzaSyAIwWDHN4xNUcHDyiPWgUCbU2NaZhDF010";
        
      
        //convert to json
        if (!empty($aidata)) {
            $data = [];
            foreach ($aidata as $row) {
                $data[] = $row;
            }
            $productionData = implode('. ', array_map('json_encode', $data));
        } else {
            echo json_encode(['message' => 'No data found']);
        }


       

        if (empty($productionData)) {
            echo 'Data not available. Please fetch the Data first.';
            return;
        }

        if ($previousResponse) {
            $requestBodyContent["previousResponse"] = $previousResponse;
        }

        if ($feedback) {
            $requestBodyContent["feedback"] = "The previous response was incorrect. Here is the method to calculate: " . $feedback;
        }

        // Prepare the request body
        $requestBody = json_encode([
            "contents" => [[
                "parts" => [["text" => $question . ". Here is the " . $dataname . " : " . $productionData . "."]]
            ]]
        ]);

        // API endpoint
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=" . $GEMINI_API_KEY;
        
        
        
        try {
            // Initialize cURL
            $ch = curl_init($url);

            // Set cURL options
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);

            // Execute the API call
            $response = curl_exec($ch);

            // Check for cURL errors
            if (curl_errno($ch)) {
                throw new Exception('cURL error: ' . curl_error($ch));
            }

            // Decode the response
            $responseBody = json_decode($response, true);

            // Close cURL
            curl_close($ch);

            // Process the response
            if (isset($responseBody['candidates'][0]['content']['parts'][0]['text'])) {
                $responseContent = $responseBody['candidates'][0]['content']['parts'][0]['text'];
                //echo "Gemini API response content: " . $responseContent . "\n";
                //echo "<div class='card-title'>Gemini API response content: ". $responseContent ."</div>";
                echo $responseContent;
              //  echo json_encode(['rawResponse' => $responseBody]);
            } else {
                throw new Exception('Unexpected API response format');
            }

            



        } catch (Exception $e) {
            echo "Error: " . $e->getMessage() . "\n";
            http_response_code(500);
            echo json_encode(['message' => 'An error occurred while calling Gemini API']);
        }
    }//function close
    


    
    public function ask_qus_from_ai()
	{
		
        if(isset($_REQUEST['search1']))
		{
			$from_date = $this->Base->change_date_ymd($_REQUEST['search_date1']);
			$to_date = $this->Base->change_date_ymd($_REQUEST['search_date2']);
			$departments = isset($_REQUEST['department']) ? $_REQUEST['department'] : [];
            $question=$_REQUEST['question'];
            $last_response=$_REQUEST['last_response']; 
            $feedback = $_REQUEST['feedback'];

            //set parament to be send
            $parameter = array('from_date'=>"$from_date", 'to_date'=>"$to_date" );
           
            $result = [];
            if (!empty($departments)) {
                foreach ($departments as $department) {
                    if ($department == "Payment") {
                        $dataname = "Customer payment data";
                        $result['customer_payment_data'][] = $this->Aimodel->payment_cr_dr($parameter);
                    } elseif ($department == "Production") {
                        $dataname = "Production data";
                        $result['production_data'][] = $this->Aimodel->production($parameter);
                    } elseif ($department == "Maintenance") {
                        $dataname = "Maintenance data, electrical and mechanical machine breakdown data";
                        $result['maintenance_data'][] = $this->Aimodel->maintenance($parameter);
                    } else {
                        $dataname = "No Data Found for $department.";
                        $result['no_data_found'][] = "No data found for $department.";
                    }
                }
            } else {
                $dataname = "No Departments Selected.";
                $result['no_data_selected'][] = "Please select at least one department.";
            }

            //print_r($result);
            $this->ask($result,$dataname,$question,$last_response,$feedback);
        }//search1
		else
		{
			echo "No data found";
            exit;
		}
	}//function close


     public function ask_qus_from_ai_popup_model()
	{
		
        if(isset($_REQUEST['search1']))
		{
			$htmlData=$_REQUEST['htmlData'];
            $question=$_REQUEST['question'];
            $last_response=$_REQUEST['last_response']; 
            $feedback = "";
            
            $dataname = "This is the raw HTML data";
            $result['erp_page_data'][] = $htmlData;

            //print_r($result);
            $this->ask($result,$dataname,$question,$last_response,$feedback);
        }//search1
		else
		{
			echo "No data found";
            exit;
		}
	}//function close







}//class close
