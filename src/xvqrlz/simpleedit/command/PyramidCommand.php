<?php

declare(strict_types=1);

namespace xvqrlz\simpleedit\command;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use xvqrlz\simpleedit\manager\EditManager;
use xvqrlz\simpleedit\Loader;

class PyramidCommand extends Command
{
    public function __construct(private Loader $plugin)
    {
        parent::__construct("/pyramid", "Generates a pyramid of blocks", "//pyramid <base_width> <height> <block_id>[:<meta>]", []);
        $this->setPermission("simpleedit.command.pyramid");
    }

    public function execute(CommandSender $sender, $label, array $args): bool
    {
        if (!$this->testPermission($sender)) {
            return false;
        }

        if (!$sender instanceof Player) {
            $sender->sendMessage(TextFormat::RED . "Only in-game");
            return false;
        }

        if (count($args) < 3) {
            $sender->sendMessage(TextFormat::RED . "Invalid usage. Correct usage: /pyramid <base_width> <height> <block_id>[:<meta>]");
            return false;
        }

        $baseWidth = (int)$args[0];
        $height = (int)$args[1];
        $blockData = explode(":", $args[2]);
        $blockId = (int)$blockData[0];
        $meta = isset($blockData[1]) ? (int)$blockData[1] : 0;

        $center = $sender->getPosition();

        EditManager::getInstance()->generatePyramid($sender, $center, $baseWidth, $height, $blockId, $meta);

        return true;
    }
}