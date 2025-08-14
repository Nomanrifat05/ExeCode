// document.addEventListener("DOMContentLoaded", function () {
//     const codeArea = document.getElementById("code");
//     const lineNumbers = document.getElementById("line-numbers");
//     const runButton = document.getElementById("run");
//     const submitButton = document.getElementById("submit");

//     // Function to update line numbers dynamically
//     function updateLineNumbers() {
//         const lines = codeArea.value.split("\n").length;
//         let lineNumbersHTML = "";
//         for (let i = 1; i <= lines; i++) {
//             lineNumbersHTML += i + "<br>";
//         }
//         lineNumbers.innerHTML = lineNumbersHTML;
//         lineNumbers.scrollTop = codeArea.scrollTop; // Ensure synchronization
//     }

//     // Event listener to update line numbers when typing
//     codeArea.addEventListener("input", updateLineNumbers);

//     // Ensure line numbers are set initially
//     updateLineNumbers();

//     // Synchronize scrolling between line numbers and code editor
//     codeArea.addEventListener("scroll", function () {
//         lineNumbers.scrollTop = codeArea.scrollTop;
//     });

//     // Run Button Click Event
//     runButton.addEventListener("click", function() {
//         let code = codeArea.value;
//         let input = document.getElementById("console").value;
        
//         if (code.trim() === "") {
//             alert("Please enter some code to run.");
//             return;
//         }

//         console.log("Running Code:\n", code);
//         console.log("Input:\n", input);
//         alert("Code executed successfully! (Simulation)");
//     });

//     // Submit Button Click Event
//     submitButton.addEventListener("click", function() {
//         let code = codeArea.value;

//         if (code.trim() === "") {
//             alert("Please enter some code before submitting.");
//             return;
//         }

//         alert("Code submitted successfully!");
//     });
// });


document.addEventListener("DOMContentLoaded", function () {
    const codeArea = document.getElementById("code");
    const lineNumbers = document.getElementById("line-numbers");
    const runButton = document.getElementById("run");
    const submitButton = document.getElementById("submit");

    // Function to update line numbers dynamically
    function updateLineNumbers() {
        const lines = codeArea.value.split("\n").length;
        lineNumbers.innerHTML = Array.from({ length: lines }, (_, i) => i + 1).join("<br>");
    }

    // Ensure line numbers are updated when typing
    codeArea.addEventListener("input", updateLineNumbers);

    // Synchronize scrolling between line numbers and code editor
    codeArea.addEventListener("scroll", function () {
        lineNumbers.scrollTop = codeArea.scrollTop;
    });

    // Ensure line numbers are set initially
    updateLineNumbers();

    // Run Button Click Event
    runButton.addEventListener("click", function() {
        let code = codeArea.value;
        let input = document.getElementById("console").value;
        
        if (code.trim() === "") {
            alert("Please enter some code to run.");
            return;
        }

        console.log("Running Code:\n", code);
        console.log("Input:\n", input);
        alert("Code executed successfully! (Simulation)");
    });

    // Submit Button Click Event
    submitButton.addEventListener("click", function() {
        let code = codeArea.value;

        if (code.trim() === "") {
            alert("Please enter some code before submitting.");
            return;
        }

        alert("Code submitted successfully!");
    });
});
