(function( $ ) {
    'use strict';
    var previousColorDrop = {};
    var styleColorDrop = document.createElement('style');
    var sheetColorDrop = document.head.appendChild(styleColorDrop).sheet;
    var MarvyColorDropAnimation = {
        initColorDrop: function () {
            elementorFrontend.hooks.addAction('frontend/element_ready/section', MarvyColorDropAnimation.initColorDropWidget);
        },
        initColorDropWidget: function ($scope) {
            let sectionId = $scope.data('id');
            let target = '.elementor-element-'+ sectionId;
            let settings = {};
            if (window.isEditMode || window.elementorFrontend.isEditMode()) {

                let colorDropEditorElements = null;
                let colorDropAnimationArgs = {};
                if (!window.elementor.hasOwnProperty('elements')) {
                    return false;
                }
                colorDropEditorElements = window.elementor.elements;
                if (!colorDropEditorElements.models) {
                    return false;
                }

                $.each(colorDropEditorElements.models, function (i, el) {
                    if (sectionId === el.id) {
                        colorDropAnimationArgs = el.attributes.settings.attributes;
                    } else if (el.id === $scope.closest('.elementor-top-section').data('id')) {
                        $.each(el.attributes.elements.models, function (i, col) {
                            $.each(col.attributes.elements.models, function (i, subSec) {
                                colorDropAnimationArgs = subSec.attributes.settings.attributes;
                            });
                        });
                    }

                    settings.switch = colorDropAnimationArgs.marvy_enable_drop_animation;
                    settings.types = colorDropAnimationArgs.marvy_drop_animation_types;
                    settings.firstColor = colorDropAnimationArgs.marvy_drop_animation_line_color;
                    settings.secondColor = colorDropAnimationArgs.marvy_drop_animation_line_color_second;
                    settings.dotColor = colorDropAnimationArgs.marvy_drop_animation_drop_dot_color;
                    settings.dotSize = colorDropAnimationArgs.marvy_drop_animation_drop_dot_size;
                    settings.speed = colorDropAnimationArgs.marvy_drop_animation_drop_speed;
                });
            }  else {
                settings.switch = $scope.data('marvy_enable_drop_animation');
                settings.types = $scope.data('marvy_drop_animation_types');
                settings.firstColor = $scope.data('marvy_drop_animation_line_color');
                settings.secondColor = $scope.data('marvy_drop_animation_line_color_second');
                settings.dotColor = $scope.data('marvy_drop_animation_drop_dot_color');
                settings.dotSize = $scope.data('marvy_drop_animation_drop_dot_size');
                settings.speed = $scope.data('marvy_drop_animation_drop_speed');
            }
            if (settings.switch) {
                let sectionKey = 'colorDrop-'+sectionId;
                if (!previousColorDrop.hasOwnProperty(sectionKey)){
                    previousColorDrop[sectionKey] = settings;
                }
                let result = colorDropAnimation(target, settings, sectionId, sectionKey);
                if (result){
                    previousColorDrop[sectionKey] = settings;
                }
            }else{
                previousColorDrop = {};
                if (sheetColorDrop.cssRules.length !== 0){
                    let j = sheetColorDrop.cssRules.length - 1;
                    for (j; j >= 0; j--) {
                        if(sheetColorDrop.cssRules[j].selectorText.includes(sectionId) ){
                            sheetColorDrop.deleteRule(j);
                        }
                    }
                }
            }
        }
    };

    $( window ).on('elementor/frontend/init', MarvyColorDropAnimation.initColorDrop);

    function addRule(selector, css, i) {
        let propText = typeof css === "string" ? css : Object.keys(css).map(function (p) {
            return p + ":" + (p === "content" ? "'" + css[p] + "'" : css[p]);
        }).join(";");
        sheetColorDrop.insertRule(selector + "{" + propText + "}", i);
    }
    function colorDropAnimation(target,settings,sectionId,sectionKey) {
        let checkElement = document.getElementsByClassName("marvy-color-drop-section-"+sectionId);
        if (checkElement.length <= 0 ) {
            let min = 1,j;
            let total = 150;
            let height = '';
            let dotSize = '';
            let time = 11 - settings.speed;
            let percent = 0.69444;
            if (settings.types === 'onlyDot') {
                height = 0;
                dotSize = settings.dotSize;
            } else if (settings.types === 'candleShape') {
                height = 50;
                dotSize = 0.3;
            } else if (settings.types === 'onlyLine') {
                height = 300;
                dotSize = 0;
            } else {
                height = 300;
                dotSize = settings.dotSize;
            }

            let i=0;
            let color_drop_div_el = document.createElement('div');
            color_drop_div_el.classList.add("marvy-color-drop-section-"+sectionId);
            document.querySelector(target).appendChild(color_drop_div_el);
            document.querySelector(target).classList.add('marvy-custom-color-drop-section-'+sectionId);

            let zIndex = document.querySelector('.marvy-custom-color-drop-section-'+sectionId+' .elementor-container');
            zIndex.style.zIndex = '99';

            let colorDropMinHeight = document.querySelector(".elementor-element-"+sectionId);
            colorDropMinHeight.closest('.elementor-top-section').style.minHeight = "400px";

            let appendColeDropRule = true;
            if (JSON.stringify(previousColorDrop[sectionKey]) !== JSON.stringify(settings)){
                appendColeDropRule = false;
                for (j = sheetColorDrop.cssRules.length - 1; j >= 0; j--) {
                    if(sheetColorDrop.cssRules[j].selectorText.includes(sectionId) ){
                        sheetColorDrop.deleteRule(j);
                    }
                    if (j === 0){
                        appendColeDropRule = true;
                        previousColorDrop[sectionKey] = settings;
                    }
                }
            }
            while(i <= total){
                let child_color_drop_div_el = document.createElement('div');
                child_color_drop_div_el.classList.add("marvy-color-drop-line-"+sectionId);
                document.querySelector(".marvy-color-drop-section-"+sectionId).appendChild(child_color_drop_div_el);


                if(appendColeDropRule) {
                    addRule(".marvy-color-drop-line-" + sectionId + ":nth-child(" + i + ")", {
                        left: ((i - 1) * percent) + '%',
                        "background-image": 'linear-gradient(to bottom,' + settings.secondColor + ',' + settings.firstColor + ')',
                        "animation-delay": (Math.random() * (total - min) + min) * (time / total) * -1 + 's'
                    });

                    addRule(".marvy-color-drop-line-" + sectionId + ":nth-child(" + i + ")" + ":after", {
                        background: settings.dotColor
                    });
                    i++;
                }
            }
            if(appendColeDropRule) {
                addRule(".marvy-color-drop-line-"+sectionId+":after", {
                    width: dotSize + 'vw',
                    height: dotSize + 'vw',
                    "border-radius": '50%',
                    left: 50 + '%',
                    bottom: (dotSize * -1) / 2 + 'vw',
                    "margin-left": (dotSize * -1) / 2 + 'vw'
                });

                addRule(".marvy-color-drop-line-"+sectionId, {
                    position: "relative",
                    height: height +'px',
                    width: percent+'%',
                    'margin-top': '-'+height+'px',
                    animation: 'drop ' + time +'s infinite ease-in'
                });
            }
        }
    }
})( jQuery );
