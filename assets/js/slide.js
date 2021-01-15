const sidebarBox = document.querySelector('#box'),
    sidebarBtn = document.querySelector('#btn'),
    pageWrapper = document.querySelector('#page-wrapper');

sidebarBtn.addEventListener('click', event => {
    sidebarBtn.classList.toggle('active');
    sidebarBox.classList.toggle('active');
});

pageWrapper.addEventListener('click', event => {

    if (sidebarBox.classList.contains('active')) {
        sidebarBtn.classList.remove('active');
        sidebarBox.classList.remove('active');
    }
});

window.addEventListener('keydown',  event => {

    if (sidebarBox.classList.contains('active') && event.keyCode === 27) {
        sidebarBtn.classList.remove('active');
        sidebarBox.classList.remove('active');
    }
});

document.getElementById('map').addEventListener('click', function(){
    sidebarBtn.classList.remove('active');
    sidebarBox.classList.remove('active');
});

const sidebarBox1 = document.querySelector('#box1'),
    sidebarBtn1 = document.querySelector('#btn1'),
    pageWrapper1 = document.querySelector('#page-wrapper1');

sidebarBtn1.addEventListener('click', event => {
    sidebarBtn1.classList.toggle('active');
    sidebarBox1.classList.toggle('active');
});

pageWrapper1.addEventListener('click', event => {

    if (sidebarBox1.classList.contains('active')) {
        sidebarBtn1.classList.remove('active');
        sidebarBox1.classList.remove('active');
    }
});
