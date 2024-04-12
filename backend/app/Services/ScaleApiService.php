<?php

namespace App\Services;

use App\Contracts\Scale\ScaleApiServiceInterface;
use Exception;
use Socket;

class ScaleApiService implements ScaleApiServiceInterface
{
    const HEADER="\xf8\x55\xce"; // Заголовок
    const CMD_GET_SCALE_PAR="\x75"; // Команда для запроса проверки весов (запрос статуса / характеристик)
    const CMD_TCP_GET_STATUS="\x23"; // Команда для запроса веса

    /**
     * Get hex numbers by position
     * For example ( f8 55 ce 0d 00 24 a3 01 00 00 02 01 00 00 00 00 00 00 f9 5d )
     * need retrive for massa ( a3 01 00 00 )
     *
     * position a3 => 6
     * position 01 => 7
     * position 00 => 8
     * position 00 => 9
     *
     * $positionList(6, 7, 8, 9)
     *
     * @param array $stringHex
     * @param array $positionList
     * @return array
     */
    public function convertHexToDec(array $stringHex, array $positionList): array
    {

        $res = [];

        foreach ($positionList as $value) {
            $res[] = hexdec($stringHex[$value]);
        }

        return $res;
    }

    /**
     * Get massa from hex and return int
     *
     * @param array $hexArrayData
     * @return int
     */
    public function convertHexArrayDataToWeightForScale(array $hexArrayData): int
    {
        return ($hexArrayData[3]<<24) + ($hexArrayData[2]<<16) + ($hexArrayData[1]<<8) + ($hexArrayData[0]);
    }

    /**
     * @param string $data
     * @return string
     */
    public function crc16(string $data): string
    {
        $crc=0;
        for ($k = 0; $k < strlen($data); $k++)
        {
            $acc=0;
            $temp=(($crc >> 8) << 8);

            for ($bits = 0; $bits < 8; $bits++)
            {
                if (($temp ^ $acc) & 0x8000) {
                    $acc = ($acc<< 1) ^ 0x1021;
                } else {
                    $acc <<= 1;
                }
                $temp <<= 1;
            }

            $crc = $acc ^ ($crc << 8) ^ (ord($data[$k]) & 0xFFFF);
        }
        return pack('s',$crc);
    }

    /**
     * Get scales info
     *
     * @param string $ip
     * @param int $port
     * @return array
     * @throws Exception
     */
    public function getScaleInfo(string $ip, int $port): array
    {
        //Запрос о наличии подключенных весов в сети
        $data=self::HEADER;
        $data.=pack('s', strlen(self::CMD_GET_SCALE_PAR));
        $data.=self::CMD_GET_SCALE_PAR;
        $data.=$this->crc16(self::CMD_GET_SCALE_PAR);

        $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        socket_set_option($sock, SOL_SOCKET, SO_BROADCAST, 1);
        socket_set_option($sock, SOL_SOCKET, SO_RCVTIMEO, array("sec"=>5, "usec"=>2));
        socket_sendto($sock, $data, strlen($data), 0, $ip, $port);

        //$err = socket_last_error();
        //$result = socket_read($sock, 1024);

        while(true) {
            $ret = @socket_recvfrom($sock, $buf, 1024, 0, $ip, $port);
            if($ret === false) break;
        }

        if ($buf == null) {
            throw new Exception("Не могу получить данные или нет связи с весами {$ip}:{$port}");
        }

        return [
            "ip" => $ip,
            "port" => $port,
            "data" => $buf,
        ];
    }

    /**
     * Send command to scales socket
     *
     * @param Socket $socket
     * @return array
     */
    public function sendCommandToSocket(Socket $socket): array
    {
        //отправка tcp пакета
        $data = self::HEADER;
        $command = self::CMD_TCP_GET_STATUS;

        if(strlen($command)==1) {
            $data.=pack('s', strlen($command));
        }

        $data.=$command;
        $data.= $this->crc16($command);

        socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array("sec"=>5, "usec"=>2));
        socket_write($socket, $data, strlen($data)) or die("Could not send data to server\n");

        $result = socket_read($socket, 1024);
//        dump($result); // If returned "false", then scales switch off

        if(!$result) {
            return [];
        }

        return explode(" ", chunk_split(bin2hex($result), 2, ' '));
    }

    /**
     * Get socket with connection or Exception if error connect
     *
     * @param string $ip
     * @param int $port
     * @return Socket
     * @throws Exception
     */
    public function getSocket(string $ip, int $port): Socket
    {
        $socket = socket_create(AF_INET, SOCK_STREAM, 0);

        if (!$socket) {
            throw new Exception("Could not create socket\n");
        }

        socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array('sec' => 10, 'usec' => 0));

        $connect = socket_connect($socket, $ip, $port);

        if (!$connect) {
            throw new Exception("Could not connect to server\n");
        }

        return $socket;
    }
}
