<?php

class Player
{
    public $name;
    public $symbol;

    public function __construct($name, $symbol)
    {
        $this->name = $name;
        $this->symbol = $symbol;
    }
}

class Board
{
    public $grid;

    public function __construct()
    {
        $this->grid = array_fill(0, 3, array_fill(0, 3, ' '));
    }

    public function display()
    {
        for ($i = 0; $i < 3; $i++) {
            echo implode(" | ", $this->grid[$i]) . "\n";
            if ($i < 2) {
                echo "---+---+---\n";
            }
        }
    }

    public function makeMove($row, $col, $symbol)
    {
        if ($this->grid[$row][$col] === ' ') {
            $this->grid[$row][$col] = $symbol;
            return true;
        }
        return false;
    }

    public function checkWin($symbol)
    {
        // Check rows, columns, and diagonals for a winning combination
        for ($i = 0; $i < 3; $i++) {
            if ($this->grid[$i][0] === $symbol && $this->grid[$i][1] === $symbol && $this->grid[$i][2] === $symbol) {
                return true;
            }
            if ($this->grid[0][$i] === $symbol && $this->grid[1][$i] === $symbol && $this->grid[2][$i] === $symbol) {
                return true;
            }
        }
        if ($this->grid[0][0] === $symbol && $this->grid[1][1] === $symbol && $this->grid[2][2] === $symbol) {
            return true;
        }
        if ($this->grid[0][2] === $symbol && $this->grid[1][1] === $symbol && $this->grid[2][0] === $symbol) {
            return true;
        }
        return false;
    }

    public function checkDraw()
    {
        // Check for a draw (all cells are filled)
        for ($i = 0; $i < 3; $i++) {
            for ($j = 0; $j < 3; $j++) {
                if ($this->grid[$i][$j] === ' ') {
                    return false;
                }
            }
        }
        return true;
    }
}

class Game
{
    protected $player1;
    protected $player2;
    protected $board;
    protected $currentPlayer;

    public function __construct(Player $player1, Player $player2)
    {
        $this->player1 = $player1;
        $this->player2 = $player2;
        $this->board = new Board();
        $this->currentPlayer = $player1;
    }

    public function start()
    {
        while (true) {
            $this->board->display();
            echo "\n" . $this->currentPlayer->name . "'s turn (" . $this->currentPlayer->symbol . "): \n";
            $row = (int) readline("Enter row (0-2): ");
            $col = (int) readline("Enter column (0-2): ");

            if ($this->board->makeMove($row, $col, $this->currentPlayer->symbol)) {
                if ($this->board->checkWin($this->currentPlayer->symbol)) {
                    $this->board->display();
                    echo $this->currentPlayer->name . " wins!\n";
                    break;
                }
                if ($this->board->checkDraw()) {
                    $this->board->display();
                    echo "It's a draw!\n";
                    break;
                }
                $this->switchPlayer();
            } else {
                echo "Invalid move. Try again.\n";
            }
        }
    }

    protected function switchPlayer()
    {
        $this->currentPlayer = ($this->currentPlayer === $this->player1) ? $this->player2 : $this->player1;
    }
}

$player1 = new Player("Player 1", 'X');
$player2 = new Player("Player 2", 'O');
$game = new Game($player1, $player2);
$game->start();

?>
