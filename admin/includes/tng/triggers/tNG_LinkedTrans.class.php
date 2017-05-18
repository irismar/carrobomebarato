<?php
/*
	Copyright (c) InterAKT Online 2000-2005
*/

	class tNG_LinkedTrans{

			var $masterTNG;
			var $detailTNG;
			var $linkField;

			function tNG_LinkedTrans(&$masterTNG, &$detailTNG) {
				$this->masterTNG = &$masterTNG;
				$this->detailTNG = &$detailTNG;
			}

			function setLink($linkField) {
				$this->linkField = $linkField;
			}

			function Execute() {
				if ($this->masterTNG->getError()) {
					return $this->onError();
				} else {
					return $this->onSuccess();
				}
			}

			function onSuccess() {
				$this->detailTNG->setColumnValue($this->linkField, $this->masterTNG->getPrimaryKeyValue());
				$this->detailTNG->executeSubSets = false;
				$this->detailTNG->setStarted(true);	
				$this->detailTNG->compileColumnsValues();
				$this->detailTNG->doTransaction();	

				return $this->detailTNG->getError();
			}

			function onError() {
				if ($this->detailTNG->isStarted()) {
					// if the 2nd transaction has started
					if (!$this->detailTNG->getError()) {
						// if it did not throw any error
						$this->detailTNG->rollBackTransaction($this->masterTNG->getError());
					}
				} else {
					$this->detailTNG->setColumnValue($this->linkField, $this->masterTNG->getPrimaryKeyValue());
					$this->detailTNG->executeSubSets = false;
					$this->detailTNG->setError($this->masterTNG->getError());
					$this->detailTNG->setStarted(true);
					$this->detailTNG->compileColumnsValues();
					$this->detailTNG->doTransaction();
				}
				return null;
			}

	}
?>