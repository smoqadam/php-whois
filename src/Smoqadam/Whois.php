<?php

namespace Smoqadam;

class Whois{

    /**
     * load servers list from whois.servers.json
     * @return mixed
     */
    private function getServers(){
        return json_decode(file_get_contents(__DIR__.'/whois.servers.json'),true);
    }

    /**
     * get domain extension
     * @param $domain
     * @return mixed
     */
    private function  getDomainExt($domain){
        $ext_tmp = explode('.',$this->cleanUp($domain));
        return end($ext_tmp);
    }


    /**
     * clean up domain name
     * @param $domain
     * @return mixed|string
     */
    private function cleanUp($domain)
    {
        $domain = trim($domain);
        $domain = strtolower($domain);
        $domain = str_replace(['http://','https://','www.'], '', $domain);
        return $domain;
    }

    /**
     * Get TLD server for specific domain
     * @param $domain
     * @return mixed
     * @throws Exception
     */
    private function getDomainServer($domain)
    {
        $servers = $this->getServers();

        $ext = $this->getDomainExt($domain);
        if(isset($servers[$ext])){
            return $servers[$ext];
        }else{
            throw new \Exception('Please specify your domain extension', 1);
        }
    }


    /**
     * return information about specific domain. set $html to TRUE for get output as HTML format
     * @param $domain
     * @param bool $html
     * @return string
     * @throws Exception
     */
    public function getDomainInfo($domain,$html=false)
    {

        $server = $this->getDomainServer($domain);
        $domain_server  = $server[0];

        $output  = '';
         // connect to whois server:
        if ($conn = fsockopen ($domain_server, 43)) {
            fputs($conn, $this->cleanUp($domain)."\r\n");
            while(!feof($conn)) {
                $output .= fgets($conn,128);
            }
            fclose($conn);
        }
        else { 
            throw new \Exception("Cannot connect to the ".$domain_server, 1);
            
        }

        if($html)
            $output = nl2br($output);

        return $output;
    }


    /**
     * Check domain is available or not
     * @param $domain
     * @return bool
     */
    public function isAvailable($domain)
    {

        $match = $this->getDomainServer($domain)[1]; 
        $result = $this->getDomainInfo($domain);

        if(strpos($result, $match) !== FALSE){

            return true;
        }

        return false;
        
    }

}

