<?php
namespace BoxOfDevs\BoxCore\Chat;
class WordList {
    protected $isLeet;
    public $reason;
    public $foundMatch;
    public $wordListLeet = array();
    public $wordList = array();
    function __construct($filename, $makeLeet = true) {
        $this->isLeet = $makeLeet;
        $this->wordList = $this->csvToArray($filename);
        if ($this->isLeet) {
            $this->wordListLeet = $this->makeListLeet( $this->wordList);
        }
        }
    function addToList( $filename ){
        $wordsToAdd = $this->csvToArray( $filename );
        $this->wordList = array_merge( $this->wordList, $wordsToAdd);
        if ($this->isLeet){
            $wordsToAddLeet = $this->makeListLeet($wordsToAdd);
            $this->wordListLeet =array_merge( $this->wordListLeet, $wordsToAddLeet);
        }
    }
    public function makeListLeet(array $wordListIn) {
        $returnWordList = array();
        $sepChars = '(\'|\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\_|\+|\-|\=';
        $sepChars .= '|\{|\}|\||\[|\]|\\\\|\:|\"|\;|\'|\<|\>|\?|\,|\.|\/|\"';
        $sepChars .= '|\~|\`|\´|\d';
        $sepChars .= ')*';
        $leet_replace['a'] = '(a+|4|@|q)';
        $leet_replace['b'] = '(b+|8|ß|Β|β)';
        $leet_replace['c'] = '(c+)';
        $leet_replace['d'] = '(d+)';
        $leet_replace['e'] = '(e+|3)';
        $leet_replace['f'] = '(f+|ph)';
        $leet_replace['g'] = '(g+|6|9)';
        $leet_replace['h'] = '(h+)';
        $leet_replace['i'] = '(i+|1|\!)';
        $leet_replace['j'] = '(j+)';
        $leet_replace['k'] = '(k+)';
        $leet_replace['l'] = '(l+|1)';
        $leet_replace['m'] = '(m+|nn)';
        $leet_replace['n'] = '(n+)';
        $leet_replace['o'] = '(o+|0)';
        $leet_replace['p'] = '(p+)';
        $leet_replace['q'] = '(q+)';
        $leet_replace['r'] = '(r+|®)';
        $leet_replace['s'] = '(s+|5|z|\$)'; 
        $leet_replace['t'] = '(t+|7)';
        $leet_replace['u'] = '(u+|v)';
        $leet_replace['v'] = '(v+|u)';
        $leet_replace['w'] = '(w+)';
        $leet_replace['x'] = '(x+|\&|\>\<|\)\()';
        $leet_replace['y'] = '(y+)';
        $leet_replace['z'] = '(z+|s)';
        for($wordIndex = 0;$wordIndex < count($wordListIn);$wordIndex++) {
            //$returnWordList[] = '/' . str_ireplace(array_keys($leet_replace), array_values($leet_replace), $wordListIn[$index]) . '/';
            $word = $wordListIn[$wordIndex];
            $wordReplacer = '';
            for ($letterIndex=0; $letterIndex < strlen($word); $letterIndex++){
                $char = substr( $word, $letterIndex, 1);
                if ( array_key_exists( $char, $leet_replace)){
                    $charReplacer = $leet_replace[$char];
                    $wordReplacer .= $charReplacer.$sepChars;
                } else {
                    $wordReplacer .= $char.$sepChars;
                }
            }
            $returnWordList[] = '/'.$wordReplacer.'/';
        }
        return $returnWordList;
    }

    function checkLeet($inString)
    {
        if (!$this->isLeet) return false;
        $matches = array();
        try {
            for ($index = 0; $index < count($this->wordListLeet); $index++) {
                if (preg_match($this->wordListLeet[$index], $inString, $matches)) {
                    $this->reason = "Found:" . $this->wordList[$index] . " Match: " . $matches[0];
                    $this->foundMatch = true;
                    return true;
                }
            }
        } catch (\Exception $e){
          return false;
        }
        $this->reason = "";
        return false;
    }

    function checkPlain($inString) {
        for($index = 0;$index < count($this->wordList);$index++) {
            // echo($index."   ".$this->wordList[ $index] ." <br>");
            $found = strstr($inString, $this->wordList[$index]);
            if($found != "") {
                $this->reason = "Found word: $found";
                $this->foundMatch = true;
                return true;
            }
        }
        $this->reason = "";
        return false;
    }

    public function replaceFromList( $inString ){
        $outString = ' '.$inString.' ';
        $NSwapped = 0;
        for( $index = 0; $index < count($this->wordList); $index++){
            $count = 0;
            $matchPattern = '/ '.$this->wordList[$index].'[ .?!]/';
            $outString = preg_replace($matchPattern, " ‡ ", $outString, -1, $count);
            $matchPattern = '/ '.$this->wordList[$index].'s[ .?!]/';
            $outString = preg_replace($matchPattern, " ‡ ", $outString, -1, $count);
            $NSwapped += $count;
        }
        $outString = preg_replace('/( ‡(\s*‡\s*)+)/',' ‡ ', $outString);
        $outString = trim($outString);
        return $outString;
    }
    function dump() {
        echo("<br>Word Entry<br>");
        for($index = 0;$index < count($this->wordList);$index++) {
            echo("<br>".$index." ".$this->wordList[$index] . " => <br>" . $this->wordListLeet[$index] . "<br>");
        }
    }
    public function csvToArray($filename) {
        $outputArray = array();
        if(!file_exists($filename)) {
            return $outputArray;
        }
        $rows = file($filename);
        foreach($rows as $row) {
            if($row[0] != ';') {
                $row = strtok($row, ';');
                $row = trim($row);
                $rowArray = explode(',', $row);
                $rowArray = array_filter($rowArray);
                $outputArray = array_merge($outputArray, $rowArray);
            }
        }
        $outputArray = array_map('trim', $outputArray);
        $outputArray = array_filter($outputArray);
        return $outputArray;
    }
}
