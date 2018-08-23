<?php

namespace OS\Code\Boggle\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use OS\Code\Boggle\Enum\GridGeneratinMethodEnum;
use OS\Code\Boggle\Entity\GridUtilities;
use OS\Code\Boggle\Entity\Boggle;

class BoggleCommand extends Command
{
    /**
     * @var InputInterface
     */
    protected $input;

    /**
     * @var OutputInterface
     */
    protected $output;

    protected function configure()
    {
        $this->setName('boggle')
            ->setDescription('Let play a game')
            ->setHelp('Need help? google it!');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $gridSize = $this->getNumberAnswer(
            'Please chose the size of the grid?'
        );

        $gridGeneratinMethod = $this->getNumberAnswer(
            'How would like to generate the grid : ' .
                GridGeneratinMethodEnum::MANUALLY . ') Manually ' .
                GridGeneratinMethodEnum::RANDOMLY . ') Randomly'
        );

        if ($gridGeneratinMethod == GridGeneratinMethodEnum::MANUALLY) {
            $grid = $this->getGridFromStr($gridSize);
        } elseif ($gridGeneratinMethod == GridGeneratinMethodEnum::RANDOMLY) {
            $grid = GridUtilities::generate($gridSize);
        } else {
            throw new \Exception('Invalid choice');
        }

        $boggle = new Boggle($grid, $output);
        $boggle->display();

        while (true) {
            $letter = $this->getWordAnswer('Please enter a word :');
            $boggle->search($letter, $output);
        }

    }

    /**
     * @param string $question
     *
     * @return string
     */
    protected function getWordAnswer($questionText)
    {
        $helper = $this->getHelper('question');
        $question = new Question($questionText . ' ');
        $question->setValidator(function ($answer) {
            if (strlen($answer) < 2) {
                throw new \RuntimeException('Please enter at least two letters');
            }

            return $answer;
        });
        $question->setMaxAttempts(2);

        return strtolower($helper->ask($this->input, $this->output, $question));
    }

    /**
     * @param int $gridSize
     */
    protected function getGridFromStr($gridSize)
    {
        $helper = $this->getHelper('question');
        $question = new Question('Please enter your grid, without space followed by | for each line
here an exemple :
```
4x4 => ARTY|EAON|YSTD|ECIC
```
: ');
        $gridContentAsString = $helper->ask($this->input, $this->output, $question);

        return GridUtilities::strToGrid($gridContentAsString, $gridSize);
    }

    /**
     * @param string $question
     *
     * @return string
     */
    protected function getNumberAnswer($questionText)
    {
        $helper = $this->getHelper('question');
        $question = new Question($questionText . ' ');
        $question->setValidator(function ($answer) {
            if (!is_numeric($answer)) {
                throw new \RuntimeException('Please enter a number.');
            }

            return $answer;
        });
        $question->setMaxAttempts(2);

        return (int) $helper->ask($this->input, $this->output, $question);
    }
}