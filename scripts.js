function showErrors() {
    
    for (let el of document.querySelectorAll('.error')) 
    {
        console.log(el);
        if (el.innerText)
            el.style.display = 'inline'}
}

function hideErrors() {

    
    for (let el of document.querySelectorAll('.error')) 
        el.style.display = 'none';
    };


setTimeout(showErrors,100);;
setTimeout(hideErrors,6000);

function scrollToElement(e) {
    const y = document.getElementById(e).getBoundingClientRect().top + window.scrollY;
    window.scroll({
    top: y,
    behavior: 'smooth'
});
}


function startQuiz() {
    document.getElementById('PreExam').style.display = 'none';
    document.getElementById('examForm').style.display = 'block'
}

function reviewQuiz() {
    document.getElementById('PostExam').style.display = 'none';
    document.getElementById('examForm').style.display = 'block'
}