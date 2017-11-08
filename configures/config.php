<?php
    class ImgConfig{
        
        private $uptypes=array(  
            'image/jpg',  
            'image/jpeg',  
            'image/png',  
            'image/pjpeg',  
            'image/gif',  
            'image/bmp',  
            'image/x-png'  
        );

        const UP_TYPES = json_encode($uptypes);

        const MAX_FILE_SIZE = 2000000;

        const DESTINATION_FOLDER = "/uploadimg/";
    }

    class RoomConfig {

        private $hosts = array("jrcn.tordian.com", "jrcn.tordian.com", "jrcn.tordian.com", "jrcn.tordian.com");;

        private $gameType = array("N", "A", "F");

        private $roomType = array(6, 9, 12);

        const HOST = json_encode($hosts);

        const PORT = 17890;

        const GAME_TYPE = json_encode($gameType);

        const ROOM_TYPE = json_encode($roomType);


    }

    class SmtpConfig {

        const HOST = 'ssl://smtp.126.com';

        const PORT = 465;

        const USERMAIL = 'jinrohMail.com';

        const USER = 'jinrohMail.com';

        const PASSWORD = 'jinrohMail123';
    }

    class DBConfig {

        const HOST = 'localhost';

        const DATABASE = 'jinRoH';

        const USERNAME = 'jr';

        const PASSWORD = 'User@123';
    }

    class RedisConfig {

        const HOST = 'localhost';

        const PORT = '6379';

        const USER_KEY = 'users';

        const USER_TOKEN_KEY = 'tokens';

        const REGISTER_TOKEN_KEY = 'register_tokens';

        const RESET_TOKEN_KEY = 'reset_tokens';

        const GAME_SESSION_KEY = 'game_sessions';

        const SIEZE_CARD_CONFIG_KEY = 'seize_card_config';

        const GAME_SETTINGS_KEY = 'game_settings';
    }

    class UserRedisConfig{

        const HOST = 'localhost';

        const PORT = '6379';
    }

    class RoomRedisConfig{

        const HOST = 'localhost';

        const PORT = '6379';

    }

?>