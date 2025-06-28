gsap.registerPlugin(ScrollTrigger);
let isSpMode = window.innerWidth > 767 ? false : true;
let linePathsTriggers = [];
let groupActiveTriggers = [];

function killLineTriggers() {
    linePathsTriggers.forEach((trigger) => trigger.kill());
    groupActiveTriggers.forEach((trigger) => trigger.kill());
}

function setupLineTriggers() {
    const allLineTriggers = document.querySelectorAll(".js-lineTrigger");
    if (allLineTriggers.length > 0) {
        allLineTriggers.forEach((trigger) => {
            const allLines = trigger.querySelectorAll(".js-linePath");
            allLines.forEach((path) => {
                const length = path.getTotalLength();
                let duration = window.innerWidth > 767 ? trigger.getAttribute("data-duration") : trigger.getAttribute("data-duration-sp");
                const offsetValue = path.getAttribute("data-direction") == "right" ? length * -1 : length;
                gsap.set(path, { strokeDasharray: length, strokeDashoffset: offsetValue, duration: 1.2, ease: "expo.inOut" });
                const newScrollTrigger = ScrollTrigger.create({
                    trigger: window.innerWidth > 767 ? trigger : path,
                    start: "top 70%",
                    end: "bottom 10%",
                    onEnter: () => {
                        gsap.to(path, { strokeDashoffset: 0, duration: duration || 0.4, stagger: 0.2, ease: "power2.inOut" });
                    },
                });
                linePathsTriggers.push(newScrollTrigger);
            });
        });
    }
}

function setupActiveTriggers() {
    const allActiveTriggers = document.querySelectorAll(".js-activeTrigger");
    if (allActiveTriggers.length > 0) {
        allActiveTriggers.forEach((trigger) => {
            ScrollTrigger.create({
                trigger: trigger,
                start: "top 70%",
                end: "bottom 10%",
                onEnter: () => {
                    trigger.classList.add("active");
                },
            });
        });
    }
}

function handleActiveGroupSingleAnime(group = []) {
    if (group.length > 0) {
        group.forEach((item, index) => {
            setTimeout(() => {
                item.classList.add("active");
            }, index * 200);
        });
    }
}

function setupSingleActiveTriggers() {
    const allActiveTriggers = document.querySelectorAll(".js-activeGroupItem");
    allActiveTriggers.forEach((item) => {
        const newScrollTrigger = ScrollTrigger.create({
            trigger: item,
            top: "top 70%",
            end: "bottom 10%",
            onEnter: () => {
                item.classList.add("active");
            },
        });
        groupActiveTriggers.push(newScrollTrigger);
    });
}

function setupGroupActiveTriggers() {
    const allGroupActiveTriggers = document.querySelectorAll(".js-activeGroupTrigger");
    if (allGroupActiveTriggers.length > 0) {
        allGroupActiveTriggers.forEach((trigger) => {
            const allSingleItems = trigger.querySelectorAll(".js-activeGroupItem");
            const windowtrigger = trigger;  // ← トリガー要素を指定
            
            const newScrollTrigger = ScrollTrigger.create({
                trigger: windowtrigger,
                start: "top 70%",  // `top` は `start` に変更
                end: "bottom 10%",
                onEnter: () => {
                    handleActiveGroupSingleAnime(allSingleItems);
                },
            });
            groupActiveTriggers.push(newScrollTrigger);
        });
    }
}


function setupSingleActiveTriggers() {
    const allActiveItems = document.querySelectorAll(".marks__item");
    allActiveItems.forEach((item) => {
        const checkElement = item.querySelector(".marks__check");
        if (!checkElement) return;

        ScrollTrigger.create({
            trigger: item,
            start: "top 80%",
            end: "bottom 10%",
            onEnter: () => {
                checkElement.classList.add("active");
            },
            onLeaveBack: () => {
                checkElement.classList.remove("active");
            },
        });
    });
}

window.addEventListener("resize", () => {
    console.log("Window resized");
    ScrollTrigger.refresh();
});

// 実行
setupSingleActiveTriggers();

// function setupFAQItems() {
//     const allFAQItems = document.querySelectorAll(".faq__item");

//     if (allFAQItems.length > 0) {
//         allFAQItems.forEach((item) => {
//             const head = item.querySelector(".faq__header");
//             const body = item.querySelector(".faq__body");
//             const content = item.querySelector(".faq__answer");
//             head.addEventListener("click", () => {
//                 body.style.maxHeight = item.classList.contains("open") ? "auto" : `${content.offsetHeight}px`;
//                 item.classList.toggle("open");
//             });
//         });
//     }
// }

document.addEventListener("DOMContentLoaded", function () {
    const faqHeaders = document.querySelectorAll(".faq__header");

    faqHeaders.forEach(function (header) {
        header.addEventListener("click", function () {
            const body = header.nextElementSibling;
            body.classList.toggle("active");
        });
    });
});

function setupSwipers() {
    const mvSwiper = new Swiper(".mv__swiper", {
        speed: 400,
        slidesPerView: 1,
        slidesPerGroup: 1,
        autoplay: {
            delay: 4000,
            pauseOnMouseEnter: true,
        },
        effect: "fade",
        fadeEffect: {
            crossFade: true,
        },
    });
}

function handleSideDrawerAction() {
    const hamburgerTriggers = document.querySelectorAll(".hamburgerTrigger");
    const header = document.querySelector(".header");
    if (hamburgerTriggers.length > 0) {
        hamburgerTriggers.forEach((trigger) => {
            trigger.addEventListener("click", (event) => {
                event.preventDefault();
                const timeout = trigger instanceof HTMLAnchorElement ? 200 : 0;
                if (timeout !== 0) {
                    const el = document.getElementById(trigger.href.split("#")[1]);
                    console.log(el);
                    el.scrollIntoView({ behavior: "instant" });
                }
                setTimeout(() => {
                    header.classList.toggle("open");
                    document.body.classList.toggle("locked");
                }, timeout);
            });
        });
    }
}

function debounce(func, delay = 300) {
    let timer;
    return function (...args) {
        clearTimeout(timer);
        timer = setTimeout(() => func.apply(this, args), delay);
    };
}

const handleResize = debounce(() => {
    if ((window.innerWidth > 767 && isSpMode) || (window.innerWidth <= 767 && !isSpMode)) {
        killLineTriggers();
        setupLineTriggers();
        if (window.innerWidth > 767) {
            setupGroupActiveTriggers();
        } else {
            setupSingleActiveTriggers();
        }
        isSpMode = !isSpMode;
    }
}, 200);

window.addEventListener("resize", handleResize);

window.addEventListener("DOMContentLoaded", () => {
    setupSwipers();
    handleSideDrawerAction();
    setupLineTriggers();
    setupActiveTriggers();
    if (window.innerWidth > 767) {
        setupGroupActiveTriggers();
    } else {
        setupSingleActiveTriggers();
    }
    // setupFAQItems();
});
