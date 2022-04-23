<?php

declare(strict_types=1);

namespace Mcbeany\BetterMinion\sessions;

class Session{

	private bool $removeMode = false;

	public function toggleRemoveMode() : bool{
		return $this->removeMode = !$this->removeMode;
	}

	public function inRemoveMode() : bool{
		return $this->removeMode;
	}

}