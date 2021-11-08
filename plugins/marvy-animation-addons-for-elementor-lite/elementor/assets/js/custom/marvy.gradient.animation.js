(function( $ ) {
    'use strict';
    var previousGradientBackground = {};
    var styleGradientBackground = document.createElement('style');
    var sheetGradientBackground = document.head.appendChild(styleGradientBackground).sheet;

    var VisualGradientBackgroundAnimation = {
        initGradientBackground: function () {
            elementorFrontend.hooks.addAction('frontend/element_ready/section', VisualGradientBackgroundAnimation.initGradientBackgroundWidget);
        },
        initGradientBackgroundWidget: function ($scope) {
            var sectionId = $scope.data('id');
            var target = '.elementor-element-' + sectionId;
            var settings = {};
            if (window.isEditMode || window.elementorFrontend.isEditMode()) {
                var editorElements = null;
                var gradientBackgroundAnimationArgs = {};

                if (!window.elementor.hasOwnProperty('elements')) {
                    return false;
                }

                editorElements = window.elementor.elements;

                if (!editorElements.models) {
                    return false;
                }

                $.each(editorElements.models, function (i, el) {
                    if (sectionId === el.id) {
                        gradientBackgroundAnimationArgs = el.attributes.settings.attributes;
                    } else if (el.id === $scope.closest('.elementor-top-section').data('id')) {
                        $.each(el.attributes.elements.models, function (i, col) {
                            $.each(col.attributes.elements.models, function (i, subSec) {
                                gradientBackgroundAnimationArgs = subSec.attributes.settings.attributes;
                            });
                        });
                    }
                    settings.switch = gradientBackgroundAnimationArgs.marvy_enable_gradient_animation;
                    settings.firstColor = gradientBackgroundAnimationArgs.marvy_gradient_animation_first_color;
                    settings.secondColor = gradientBackgroundAnimationArgs.marvy_gradient_animation_second_color;
                    settings.thirdColor = gradientBackgroundAnimationArgs.marvy_gradient_animation_third_color;
                    settings.fourthColor = gradientBackgroundAnimationArgs.marvy_gradient_animation_fourth_color;
                    settings.degree = gradientBackgroundAnimationArgs.marvy_gradient_animation_degree;
                    settings.duration = gradientBackgroundAnimationArgs.marvy_gradient_animation_duration;
                });

            } else {
                settings.switch = $scope.data("marvy_enable_gradient_animation");
                settings.firstColor = $scope.data("marvy_gradient_animation_first_color");
                settings.secondColor = $scope.data("marvy_gradient_animation_second_color");
                settings.thirdColor = $scope.data("marvy_gradient_animation_third_color");
                settings.fourthColor = $scope.data("marvy_gradient_animation_fourth_color");
                settings.degree = $scope.data("marvy_gradient_animation_degree");
                settings.duration = $scope.data("marvy_gradient_animation_duration");
            }

            if (settings.switch) {
                var sectionKey = 'gradientBackground-'+sectionId;
                if (!previousGradientBackground.hasOwnProperty(sectionKey)){
                    previousGradientBackground[sectionKey] = settings;
                }

                var result = gradientBackgroundAnimation(target, settings, sectionId, sectionKey);
                if (result){
                    previousGradientBackground[sectionKey] = settings;
                }
            } else {
                previousGradientBackground = {};
                if (sheetGradientBackground.cssRules.length !== 0){
                    for (var j = sheetGradientBackground.cssRules.length - 1; j >= 0; j--) {
                        if(sheetGradientBackground.cssRules[j].selectorText.includes(sectionId) ) {
                            sheetGradientBackground.deleteRule(j);
                        }
                    }
                }
            }
        }
    };

    function addRule(selector, css) {
        var propText = typeof css === "string" ? css : Object.keys(css).map(function (p) {
            return p + ":" + (p === "content" ? "'" + css[p] + "'" : css[p]);
        }).join(";");
        sheetGradientBackground.insertRule(selector + "{" + propText + "}", sheetGradientBackground.cssRules.length);
    }

    function gradientBackgroundAnimation(target, settings, sectionId, sectionKey) {

        var checkElement = document.getElementsByClassName("marvy-gradientBackground-section-" + sectionId);

        if (checkElement.length >= 0) {

            var gradientBackground_div = document.createElement('div');
            gradientBackground_div.classList.add("marvy-gradientBackground-section-" + sectionId);

            document.querySelector(target).appendChild(gradientBackground_div);
            document.querySelector(target).classList.add("marvy-custom-gradientBackground-animation-section-" + sectionId);

            // Set Z-index for section container
            var gradientBackgroundZindex = document.querySelector('.marvy-custom-gradientBackground-animation-section-'+sectionId+' .elementor-container');
            gradientBackgroundZindex.style.zIndex = '99';

            var appendGradientBackground = true;

            if (JSON.stringify(previousGradientBackground[sectionKey]) !== JSON.stringify(settings)){
                appendGradientBackground = false;
                for (var j = sheetGradientBackground.cssRules.length - 1; j >= 0; j--) {
                    if(sheetGradientBackground.cssRules[j].selectorText.includes(sectionId) ) {
                        sheetGradientBackground.deleteRule(j);
                    }
                    if (j === 0){
                        appendGradientBackground = true;
                        previousGradientBackground[sectionKey] = settings;
                    }
                }
            }
            while (!appendGradientBackground){}

            addRule(".marvy-gradientBackground-section-"+sectionId, {
                background: "linear-gradient(-"+settings.degree+"deg, "+settings.fourthColor+", "+settings.thirdColor+", "+settings.secondColor+", "+settings.firstColor+")",
                "background-size": "400% 400%",
                animation: "gradient "+settings.duration+"s ease infinite"
            });
        }
        return true;
    }

    $( window ).on('elementor/frontend/init', VisualGradientBackgroundAnimation.initGradientBackground);
})( jQuery );
