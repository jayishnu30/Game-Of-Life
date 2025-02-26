<?php
class GameOfLife {
    private $grid;
    private $size;

    public function __construct($size) {
        $this->size = $size;
        $this->grid = array_fill(0, $size, array_fill(0, $size, 0));
    }

    public function initializeGlider() {
        $mid = intval($this->size / 2);
        $this->grid[$mid][$mid - 1] = 1;
        $this->grid[$mid + 1][$mid] = 1;
        $this->grid[$mid - 1][$mid + 1] = 1;
        $this->grid[$mid][$mid + 1] = 1;
        $this->grid[$mid + 1][$mid + 1] = 1;
    }

    private function countNeighbors($i, $j) {
        $count = 0;
        for ($di = -1; $di <= 1; $di++) {
            for ($dj = -1; $dj <= 1; $dj++) {
                if ($di == 0 && $dj == 0) continue;
                $ni = $i + $di;
                $nj = $j + $dj;
                if ($ni >= 0 && $ni < $this->size && $nj >= 0 && $nj < $this->size && ($this->grid[$ni][$nj] & 1)) {
                    $count++;
                }
            }
        }
        return $count;
    }

    public function evolve() {
        for ($i = 0; $i < $this->size; $i++) {
            for ($j = 0; $j < $this->size; $j++) {
                $n = $this->countNeighbors($i, $j);
                if ($this->grid[$i][$j]) {
                    $this->grid[$i][$j] = ($n == 2 || $n == 3) ? 1 : 2;
                } else {
                    $this->grid[$i][$j] = $n == 3 ? 3 : 0;
                }
            }
        }
        for ($i = 0; $i < $this->size; $i++) {
            for ($j = 0; $j < $this->size; $j++) {
                $this->grid[$i][$j] = $this->grid[$i][$j] % 2;
            }
        }
    }

    public function printGrid($generation) {
        echo "Generation $generation:\n";
        foreach ($this->grid as $row) {
            echo str_replace([0, 1], ['.', 'X'], implode('', $row)) . "\n";
        }
        echo "\n";
    }
}

$size = 25;
$game = new GameOfLife($size);
$game->initializeGlider();

$game->printGrid(0); 
for ($g = 1; $g <= 4; $g++) {
    $game->evolve();
    $game->printGrid($g);
}
?>