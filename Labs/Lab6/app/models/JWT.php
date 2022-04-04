<?php
class JWT
{
    // JWT Header code (algorithm, type, etc)
    private $headers;
    private $secret;

    public function __construct()
    {
        $this->headers = [
            'alg' => 'HS256', // Algorithm
            'typ' => 'JWT', // type of token
        ];
        $this->secret = 'secret'; // secret key
    }

    // Generates JWT using the provided payload array
    public function generate(array $payload): string
    {
        $headers = $this->encode(json_encode($this->headers)); // encode headers
        $payload = $this->encode(json_encode($payload)); // encode payload
        $signature = hash_hmac('SHA256', "$headers.$payload", $this->secret, true); // create signature
        $signature = $this->encode($signature); // encode signature

        return "$headers.$payload.$signature"; // return encoded JWT
    }

    // Encodes JWT using base64url encoding
    private function encode(string $str): string
    {
        return rtrim(strtr(base64_encode($str), '+/', '-_'), '='); // base64 encode string
    }

    // Checks if the JWT is valid 
    public function is_valid(string $jwt): bool
    {
        $token = explode('.', $jwt); // explode token based on header, payload and signature
        if (!isset($token[1]) && !isset($token[2])) {
            echo "Bad Token";
            return false; // if tokens do not match, return false
        }
        $headers = base64_decode($token[0]); // decode header, create variable
        $payload = base64_decode($token[1]); // decode payload, create variable
        $clientSignature = $token[2]; // create variable for signature

        if (!json_decode($payload)) {
            echo "Bad Token";
            return false; // fails if payload does not decode
        }

        $base64_header = $this->encode($headers);
        $base64_payload = $this->encode($payload);

        $signature = hash_hmac('SHA256', $base64_header . "." . $base64_payload, $this->secret, true);
        $base64_signature = $this->encode($signature);

        return ($base64_signature === $clientSignature);
    }

    // Decodes JWT using base64url encoding and returns payload
     public function getUsername(string $jwt)
    {
        $token = explode('.', $jwt); // explode token based on JWT breaks
        if (!isset($token[1]) && !isset($token[2])) {
            echo "Bad Token";
            return false; // if headers and payload do not match, return false
        }
        $headers = base64_decode($token[0]); // decode header
        $payload = base64_decode($token[1]); // decode payload
        $clientSignature = $token[2]; // set signature

        if (!json_decode($payload)) {
            echo "Bad Token";
            return false; // if decode fails, return false
        }

        // decode payload
        $data = json_decode($payload, TRUE);
        $base64_header = $this->encode($headers);
        $base64_payload = $this->encode($payload);
        $data = json_decode($payload, TRUE);
        $signature = hash_hmac('SHA256', $base64_header . "." . $base64_payload, $this->secret, true);
        $base64_signature = $this->encode($signature);
        if ($base64_signature === $clientSignature) {
            return $data['username']; // return username
        }
    }
}
