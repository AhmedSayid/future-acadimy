//DOM elements
const DOMstrings = {
    stepsBtnClass: 'multiSteps-progress-btn',
    stepsBtns: document.querySelectorAll(`.multiSteps-progress-btn`),
    stepsBar: document.querySelector('.multisteps-form__progress'),
    stepsForm: document.querySelector('.multisteps-form__form'),
    stepsFormTextareas: document.querySelectorAll('.multisteps-form__textarea'),
    stepFormPanelClass: 'multisteps-form__panel',
    stepFormPanels: document.querySelectorAll('.multisteps-form__panel'),
    stepPrevBtnClass: 'js-btn-prev',
    stepNextBtnClass: 'js-btn-next',
    styleClass: 'text-white bg-gradient-primary',
};


//remove class from a set of items
const removeClasses = (elemSet, className) => {

    elemSet.forEach(elem => {

        elem.classList.remove(className);

    });

};

//return exect parent node of the element
const findParent = (elem, parentClass) => {

    let currentNode = elem;

    while (!currentNode.classList.contains(parentClass)) {
        currentNode = currentNode.parentNode;
    }

    return currentNode;

};

//get active button step number
const getActiveStep = elem => {
    return Array.from(DOMstrings.stepsBtns).indexOf(elem);
};

//set all steps before clicked (and clicked too) to active
const setActiveStep = activeStepNum => {

    //remove active state from all the state
    removeClasses(DOMstrings.stepsBtns, 'js-active');

    //set picked items to active
    DOMstrings.stepsBtns.forEach((elem, index) => {

        if (index == activeStepNum) {
            elem.classList.add('js-active');
        }

    });
};

//get active panel
const getActivePanel = () => {

    let activePanel;

    DOMstrings.stepFormPanels.forEach(elem => {

        if (elem.classList.contains('js-active')) {

            activePanel = elem;

        }

    });

    return activePanel;

};

//open active panel (and close unactive panels)
const setActivePanel = activePanelNum => {

    //remove active class from all the panels
    removeClasses(DOMstrings.stepFormPanels, 'js-active');

    //show active panel
    DOMstrings.stepFormPanels.forEach((elem, index) => {
        if (index === activePanelNum) {

            elem.classList.add('js-active');

            setFormHeight(elem);

        }
    });

};

//set form height equal to current panel height
const formHeight = activePanel => {

    const activePanelHeight = activePanel.offsetHeight;

    DOMstrings.stepsForm.style.height = `${activePanelHeight}px`;

};

const setFormHeight = () => {
    const activePanel = getActivePanel();

    formHeight(activePanel);
};

//STEPS BAR CLICK FUNCTION
DOMstrings.stepsBar.addEventListener('click', e => {

    //check if click target is a step button
    const eventTarget = e.target;

    if (!eventTarget.classList.contains(`${DOMstrings.stepsBtnClass}`)) {
        return;
    }

    //get active button step number
    const activeStep = getActiveStep(eventTarget);

    if(document.getElementById('checkStepClick').value === 'true'){
        setActiveStep(activeStep);
        setActivePanel(activeStep);
    }
});

//PREV/NEXT BTNS CLICK
DOMstrings.stepsForm.addEventListener('click', e => {

    const eventTarget = e.target;

    //check if we clicked on `PREV` or NEXT` buttons
    if (!(eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`) || eventTarget.classList.contains(`${DOMstrings.stepNextBtnClass}`))) {
        return;
    }

    //find active panel
    const activePanel = findParent(eventTarget, `${DOMstrings.stepFormPanelClass}`);

    let activePanelNum = Array.from(DOMstrings.stepFormPanels).indexOf(activePanel);

    //set active step and active panel onclick
    if (eventTarget.classList.contains(`${DOMstrings.stepPrevBtnClass}`)) {
        activePanelNum--;

    } else {

        activePanelNum++;

    }

    setActiveStep(activePanelNum);
    setActivePanel(activePanelNum);

});

//SETTING PROPER FORM HEIGHT ONLOAD
window.addEventListener('load', setFormHeight, false);

//SETTING PROPER FORM HEIGHT ONRESIZE
window.addEventListener('resize', setFormHeight, false);


// const questionButtons = document.querySelectorAll('.pagination-list a');
// const cards = document.querySelectorAll('.card');
// const nextButton = document.getElementById('nextButton');
//
// questionButtons.forEach(button => {
//     button.addEventListener('click', function (event) {
//         event.preventDefault();
//         // إزالة الشكل المميز من جميع الأزرار
//         questionButtons.forEach(btn => {
//             btn.classList.remove('text-white', 'bg-gradient-primary');
//         });
//         // إضافة الشكل المميز للزر الذي تم النقر عليه
//         this.classList.add('text-white', 'bg-gradient-primary');
//         const targetId = this.getAttribute('href').substring(1); // استخراج الهدف من href
//         showQuestion(targetId); // عرض السؤال المستهدف
//     });
// });
//
//
// // تحديث الواجهة لعرض السؤال المستهدف
// function showQuestion(questionId) {
//     cards.forEach(card => {
//         card.style.display = 'none'; // إخفاء جميع الكروت
//     });
//
//     const targetQuestion = document.getElementById(questionId);
//     if (targetQuestion) {
//         targetQuestion.style.display = 'block'; // عرض الكارت المستهدف
//     }
// }
//
// // العرض الافتراضي للسؤال الأول عند تحميل الصفحة
// window.addEventListener('load', function () {
//     showQuestion('q1');
// });
