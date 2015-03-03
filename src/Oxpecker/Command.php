<?php

namespace Oxpecker;

use Psy\Command\Command as BaseCommand;
use Psy\Presenter\PresenterManager;
use Psy\Presenter\PresenterManagerAware;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Command extends BaseCommand implements PresenterManagerAware
{
    protected $consumerKey;

    protected $consumerSecret;

    protected $accessToken;

    protected $accessTokenSecret;
    /** @var PresenterManager */
    protected $presenterManager;
    /** @var Client */
    protected $client;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('twitter')
            ->setDefinition(array(
                new InputOption('message', 'm', InputOption::VALUE_OPTIONAL, 'Message to send.'),
                new InputOption('timeline', 't', InputOption::VALUE_NONE, 'Retrieves the timeline.'),
                new InputOption('count', 'c', InputOption::VALUE_OPTIONAL, 'Number of items from timeline to retrieve.'),
            ))
            ->setDescription('Sends a message to twitter.')
            ->setHelp(
                <<<HELP
Sends a message to twitter.
Example:
 twitter -m "Hi there twitter" // sends the message to twitter
 twitter --timeline // displays the timeline via a presenter
HELP
            );
        $this->client = new Client($this->consumerKey, $this->consumerSecret, $this->accessToken, $this->accessTokenSecret);
    }
    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $message = $input->getOption('message');
        if ($message) {
            $this->client->tweet($message);
            return $output->writeln('<info>Message sent!</info>');
        }
        $timeline = $input->getOption('timeline');
        if ($timeline) {
            $numItems = $input->getOption('count');
            if (is_null($numItems)) {
                $numItems = 25;
            }

            $items = $this->client->getUserTimeline($numItems);
            return $output->page($this->presenterManager->present($items));
        }

        return $output->writeln($this->getHelp());
    }

    /**
     * Set a reference to the PresenterManager.
     *
     * @param PresenterManager $manager
     */
    public function setPresenterManager(PresenterManager $manager)
    {
        $this->presenterManager = $manager;
    }
}
