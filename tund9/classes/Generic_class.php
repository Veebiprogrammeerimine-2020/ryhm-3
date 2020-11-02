<?php
	class Generic{
		//muutujad ehk properties (omadused)
		private $secretnumber;
		public $availablenumber;
		
		//konstruktor
		function __construct(){
			$this->secretnumber = mt_rand(0, 100);
			$this->availablenumber = mt_rand(0, 100);
			echo "Korrutis on: " .($this->secretnumber * $this->availablenumber) ."\n";
			$this->tellSecret();
		}//constructor lõppeb
		
		function __destruct(){
			echo "Klassiga on nüüd kõik!";
		}
		
		//funktsioonid ehk methods (meetodid)
		private function tellSecret(){
			echo "Näidisklass on mõttetu!";
		}
		
		public function showValues(){
			echo "Salajane number on: " .$this->secretnumber;
		}
		
		
	}//class lõppeb