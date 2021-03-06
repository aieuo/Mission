<?php

/**
 * Copyright (c) 2020 PJZ9n.
 *
 * This file is part of Mission.
 *
 * Mission is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Mission is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Mission. If not, see <http://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

namespace pjz9n\mission\form\executor;

use pjz9n\mission\form\generic\MessageForm;
use pjz9n\mission\language\LanguageHolder;
use pjz9n\mission\mission\executor\Executor;
use pjz9n\mission\mission\executor\ExecutorList;
use pjz9n\mission\pmformsaddon\AbstractModalForm;
use pocketmine\Player;
use ReflectionException;

class ExecutorRemoveConfirmForm extends AbstractModalForm
{
    /** @var Executor */
    private $executor;

    /**
     * @throws ReflectionException
     */
    public function __construct(Executor $executor)
    {
        parent::__construct(
            LanguageHolder::get()->translateString("executor.edit.remove.confirm"),
            LanguageHolder::get()->translateString("executor.edit.remove.confirm.message", [$executor->getDetail()]),
            LanguageHolder::get()->translateString("ui.yes"),
            LanguageHolder::get()->translateString("ui.no")
        );
        $this->executor = $executor;
    }

    /**
     * @throws ReflectionException
     */
    public function onSubmit(Player $player, bool $choice): void
    {
        if (!$choice) {
            $player->sendForm(new ExecutorActionSelectForm($this->executor));
            return;
        }
        ExecutorList::remove($this->executor);
        $player->sendForm(new MessageForm(LanguageHolder::get()->translateString("executor.edit.remove.success", [
            $this->executor->getDetail(),
        ]), new ExecutorListForm($this->executor->getParentMission())));
    }
}
