<?php

class CI_Mongo extends Mongo
{
    var $db;

    function CI_Mongo()
    {
        // Fetch CodeIgniter instance
        $ci = get_instance();
        // Load Mongo configuration file
        $ci->load->config('mongo');

        // Fetch Mongo server and database configuration
        $server = $ci->config->item('mongo_server');
        $dbname = $ci->config->item('mongo_dbname');

        // Initialise Mongo
        try {
            if ($server)
            {
                parent::__construct($server);
            }
            else
            {
                parent::__construct();
            }
        } catch (MongoConnectionException $e) {
            die('Error conectando al servidor MongoDB. Servidor: '. $server.'. Error: ' . $e->getMessage() . '. ¿Esta levantado el servidor?');
        } catch (MongoException $e) {
            die('Error: ' . $e->getMessage());
        }

        $this->db = $this->$dbname;
    }
}

?>
