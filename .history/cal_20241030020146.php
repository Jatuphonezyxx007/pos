<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Calculator</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/17.0.2/umd/react.production.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react-dom/17.0.2/umd/react-dom.production.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-standalone/6.26.0/babel.min.js"></script>
    <style>
        body {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div id="root"></div>

    <script type="text/babel">
        const POSCalculator = () => {
            const [display, setDisplay] = React.useState('0');
            const [total, setTotal] = React.useState(0);
            const [isPaymentMode, setIsPaymentMode] = React.useState(false);

            const addToDisplay = (value) => {
                if (display === '0') {
                    setDisplay(value);
                } else {
                    setDisplay(display + value);
                }
            };

            const deleteLastChar = () => {
                if (display.length === 1) {
                    setDisplay('0');
                } else {
                    setDisplay(display.slice(0, -1));
                }
            };

            const calculateTotal = () => {
                setTotal(parseFloat(display));
                setIsPaymentMode(true);
                setDisplay('0');
            };

            const handlePayment = () => {
                const payment = parseFloat(display);
                const change = payment - total;
                if (change >= 0) {
                    setDisplay(change.toFixed(2));
                } else {
                    setDisplay('ยอดเงินไม่พอ');
                }
                setIsPaymentMode(false);
            };

            return (
                <div className="card w-50 mx-auto">
                    <div className="card-body">
                        <input
                            type="text"
                            value={display}
                            readOnly
                            className="form-control mb-3 text-right"
                        />
                        {isPaymentMode && (
                            <div className="text-right text-muted">
                                ยอดที่ต้องชำระ: {total.toFixed(2)} บาท
                            </div>
                        )}
                        <div className="grid grid-cols-4 gap-2">
                            {/* Row 1 */}
                            <button onClick={() => addToDisplay('7')} className="btn btn-light">7</button>
                            <button onClick={() => addToDisplay('8')} className="btn btn-light">8</button>
                            <button onClick={() => addToDisplay('9')} className="btn btn-light">9</button>
                            <button onClick={() => addToDisplay('1000')} className="btn btn-primary">1000</button>

                            {/* Row 2 */}
                            <button onClick={() => addToDisplay('4')} className="btn btn-light">4</button>
                            <button onClick={() => addToDisplay('5')} className="btn btn-light">5</button>
                            <button onClick={() => addToDisplay('6')} className="btn btn-light">6</button>
                            <button onClick={() => addToDisplay('500')} className="btn btn-primary">500</button>

                            {/* Row 3 */}
                            <button onClick={() => addToDisplay('1')} className="btn btn-light">1</button>
                            <button onClick={() => addToDisplay('2')} className="btn btn-light">2</button>
                            <button onClick={() => addToDisplay('3')} className="btn btn-light">3</button>
                            <button onClick={() => addToDisplay('100')} className="btn btn-primary">100</button>

                            {/* Row 4 */}
                            <button onClick={() => addToDisplay('.')} className="btn btn-light">.</button>
                            <button onClick={() => addToDisplay('0')} className="btn btn-light">0</button>
                            <button onClick={deleteLastChar} className="btn btn-danger">ลบ</button>
                            {isPaymentMode ? (
                                <button onClick={handlePayment} className="btn btn-success">คำนวณ</button>
                            ) : (
                                <button onClick={calculateTotal} className="btn btn-success">เต็ม</button>
                            )}
                        </div>
                    </div>
                </div>
            );
        };

        ReactDOM.render(<POSCalculator />, document.getElementById('root'));
    </script>
</body>
</html>
