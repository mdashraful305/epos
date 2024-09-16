<style>
    .calculator {
        width: 350px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    #display {
        width: 310px;
        height: 60px;
        background-color: #f4f4f4;
        border: none;
        text-align: right;
        font-size: 28px;
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 5px;
    }

    .calculator .buttons {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-gap: 10px;
    }

    .calculator .btn {
        padding: 18px;
        font-size: 20px;
        background-color: #ececec;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .calculator .btn:hover {
        background-color: #dcdcdc;
    }

    .calculator .equal {
        grid-column: span 2;
        background-color: #4CAF50;
        color: #fff;
    }

    .calculator .equal:hover {
        background-color: #45a049;
    }

    .calculator .del {
        background-color: #ff0000;
        color: #fff;
    }

    .calculator .del:hover {
        background-color: #cf1818eb;
        color: #fff;
    }
    </style>
        <div class="calculator">
            <input type="text" id="display" disabled>
            <div class="buttons">
                <button class="btn del" onclick="clearDisplay()">C</button>
                <button class="btn del" onclick="deleteLast()">DEL</button>
                <button class="btn" onclick="appendToDisplay('/')">/</button>
                <button class="btn" onclick="appendToDisplay('*')">*</button>
                <button class="btn" onclick="appendToDisplay('7')">7</button>
                <button class="btn" onclick="appendToDisplay('8')">8</button>
                <button class="btn" onclick="appendToDisplay('9')">9</button>
                <button class="btn" onclick="appendToDisplay('-')">-</button>
                <button class="btn" onclick="appendToDisplay('4')">4</button>
                <button class="btn" onclick="appendToDisplay('5')">5</button>
                <button class="btn" onclick="appendToDisplay('6')">6</button>
                <button class="btn" onclick="appendToDisplay('+')">+</button>
                <button class="btn" onclick="appendToDisplay('1')">1</button>
                <button class="btn" onclick="appendToDisplay('2')">2</button>
                <button class="btn" onclick="appendToDisplay('3')">3</button>
                <button class="btn" onclick="appendToDisplay('0')">0</button>
                <button class="btn" onclick="appendToDisplay('.')">.</button>
                <button class="btn equal" onclick="calculateResult()">=</button>
            </div>
        </div>

    <script>
    document.addEventListener('keydown', function(event) {
        const key = event.key;
        const display = document.getElementById("display");

        if (isDigit(key) || isOperator(key)) {
            appendToDisplay(key);
        } else if (key === 'Enter') {
            event.preventDefault();
            calculateResult();
        } else if (key === 'Backspace') {
            deleteLast();
        } else if (key === 'Delete') {
            clearDisplay();
        } else if (key === '.') {
            appendToDisplay('.');
        }
    });

    function isDigit(key) {
        return /\d/.test(key);
    }

    function isOperator(key) {
        return ['+', '-', '*', '/'].includes(key);
    }

    function appendToDisplay(value) {
        document.getElementById("display").value += value;
    }

    function clearDisplay() {
        document.getElementById("display").value = '';
    }

    function deleteLast() {
        let display = document.getElementById("display");
        display.value = display.value.slice(0, -1);
    }

    function calculateResult() {
        try {
            let display = document.getElementById("display");
            display.value = eval(display.value);
        } catch (e) {
            alert("Invalid Expression");
            clearDisplay();
        }
    }
    </script>
