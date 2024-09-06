<?php 
    class ComplexNumber {
        private int $real;
        private int $imaginary;

        public function __construct(int $real, int $imaginary) {
            $this->real = $real;
            $this->imaginary = $imaginary;
        }

        public function add(ComplexNumber $other): ComplexNumber {
            $real = $this->real + $other->real;
            $imaginary = $this->imaginary + $other->imaginary;
            return new ComplexNumber($real, $imaginary);
        }

        public function subtract(ComplexNumber $other): ComplexNumber {
            $real = $this->real - $other->real;
            $imaginary = $this->imaginary - $other->imaginary;
            return new ComplexNumber($real, $imaginary);
        }

        public function multiply(ComplexNumber $other): ComplexNumber {
            $real = $this->real * $other->real - $this->imaginary * $other->imaginary;
            $imaginary = $this->real * $other->imaginary + $this->imaginary * $other->real;
            return new ComplexNumber($real, $imaginary);
        }

        public function __toString() {
            if ($this->imaginary < 0) {
                return "{$this->real} - " . abs($this->imaginary) . "i";
            }
            return "{$this->real} + {$this->imaginary}i";
        }
    }
