<?php
namespace App\Command;

use App\Repository\ResidentRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:import-residents')]
class ImportResidentsCommand extends Command
{
    public function __construct(private ResidentRepository $residentRepository)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Import residents from json file')
            ->setHelp('Imports residents')
            ->addArgument('username', InputArgument::REQUIRED, 'Username');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $username = $input->getArgument('username');
        $output->writeln("Starting the import for user: $username");
        //import data
        $residents = $this->residentRepository->importResidentsFromFile();
        //output data
        foreach ($residents as $resident) {
            $output->writeln($resident['username']);
        }

        $output->writeln(['Import is done.', 'Done!']);

        return Command::SUCCESS;
    }
}