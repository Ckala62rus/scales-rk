<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class PublishRabbitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbit:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send testing message to RabbitMQ';

    /**
     * Execute the console command.
     *
     * @return int
     * @throws Exception
     */
    public function handle()
    {
        $connection = new AMQPStreamConnection(
            'rabbitmq-new-template',
            5672,
            'root',
            '123123'
        );
        $channel = $connection->channel();

        $channel->queue_declare(
            'hello',
            false,
            false,
            false,
            false
        );

        $data = json_encode([
            "ip" => "127.0.0.1",
            "status" => true,
            "message" => "this message from publish command"
        ]);

        $msg = new AMQPMessage($data);
        $channel->basic_publish($msg, '', 'hello');

        echo " [x] Sent 'Hello World!'\n";

        $channel->close();
        $connection->close();

        return Command::SUCCESS;
    }
}
