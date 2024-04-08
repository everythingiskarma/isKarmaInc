// SEARCH FUNCTIONALITY
// declare the last search term
var lastKeyword = "";
// clear search input
$(document).on("click", "#clearSearch", function() {
    $("#searchInput input").val("");
});
// start ajax search keyword request
$(document).on("keyup", "#searchInput input", function() {
    // process keyword before making post request
    var keyword = $(this).val().trim();

    // trigger click event on returnToResults element
    $("#returnToResults").trigger("click");
    // toggle searching indication animation
    $("#searching").fadeIn();

    delay(function() {
        if(keyword.length < 3) {
            // suggest entering at least 5 characters to begin search
            // clear search results if keyword is empty
            $("#searchResults").html("<div class='noResults'>Please enter at least 5 characters to begin search...</div>");
            // exit early if keyword is empty
            $("#searching").fadeOut();
            return;
        }
        // check if the search term has changed since the last search
        if(keyword == lastKeyword) {
            $("#searching").fadeOut();
            // do nothing exit early
            return;
        } else {
            // Update lastKeyword with the current keyword
            lastKeyword = keyword;
            // prepare request post data
            var requestData = {
                searchKeyword: keyword,
                requestFrom: domain
            };
        }
        // send post request.stop().
        processRequest('api/static/search.php', requestData, successCallback, errorCallback);

        // function to handle search success response
        function successCallback(report) {
            //console.log(report);
            if(Array.isArray(report) && report.length > 0) {
                // destructure the array and assign keys as variables
                var {api,action,result,message,content} = report[0];
                //console.log (api);
                //console.log (action);
                //console.log (result);
                //console.log (message);
                //console.log (content);
                //console.log (content.hits);
                //console.log(results);
                var results = content.results;
                var resultsHtml = '<ul>';
                //var categories = [];
                $.each(results, function(index, result) {
                    var {matchingSentence, pageId, pageImage, pageIntro, pagePath, pageTitle, pageType} = result;
                    // construct html for each search result
                    resultsHtml += '<li id="'+pageId+'" location="'+pagePath+'">';
                    //resultsHtml += '<div class="image">'+ pageImage +'</div>';
                    resultsHtml += '<div class="desc">';
                    resultsHtml += '<div class="type" filter='+pageType+'>'+ pageType +'</div>';
                    resultsHtml += '<h1>' + pageTitle + '</h1>';
                    resultsHtml += '<div>' + matchingSentence + '</div>';
                    resultsHtml += '<intro>' + pageIntro + '</intro>';
                    resultsHtml += '</div>';
                    resultsHtml += '</li>';
                });
                resultsHtml += '</ul>';
                $("#searchResults").html(resultsHtml);
                $("#searchFilters").slideDown();
                $("#searchFiltersToggle").fadeIn();
                $("#searchResults").animate({scrollTop: 0}, 400);

                var filterCat = $('.filterCat');
                filterCat.empty();// clear previous categories
                // get list of categories
                var cats = content.categories;
                $.each(cats, function(catName, catCount) {
                    var cat = $('<a name="'+catName+'">' + catName + '<span>' + catCount + '</span></a>');
                    filterCat.append(cat);
                });

                var allCat = '<a name="all">all <span>'+ content.hits +'</span></a>';
                filterCat.prepend(allCat);

                //console.log(categories);
                $("#searching").fadeOut();

                if(content.length === 0) {
                    $("#searchResults").html("<div class='noResults'>No results found matching your query! Please try a different keyword!</div>");
                    $("#searching").fadeOut();
                } else {
                }
            } // end if is array
        } // end successCallback

        function errorCallback(xhr, status, error) {
            var errorMessage = 'Error occurred while processing the request. Please try again later.';
            console.error('AJAX error:', error);
            $("#searchResults").html('<div class="error">' + errorMessage + '</div>');
            $("#searching").fadeOut();
        }

        // Update lastKeyword when the tab gains or loses visibility
        $(document).on("visibilitychange", function() {
            if (!document.hidden) {
                // If tab becomes visible, update lastKeyword with current input value
                lastKeyword = $("#searchInput input").val().trim();
            }
        });

    }, 2000);
}); // end ajax search keyword request

$(document).on("click", ".filterCat a", function() {
    $(this).addClass("active").siblings().removeClass("active");
    var showCat = $(this).attr("name");
    if(showCat === 'all') {
        $("#searchResults li").slideDown();
        return;
    }
    filterCat(showCat);
});

// function to hide other categories
function filterCat(showCat) {
    $("#searchResults li").each(function() {
        var resCat = $(this).find(".type").attr("filter");
        if (resCat === showCat) {$(this).slideDown();}
        else {$(this).slideUp();}
    });
}

// SEARCH PERSPECTIVE CONTENT REQUEST
// start ajax search result full view content request
$(document).on("click", "#searchResults li", function() {
    // prepare request post data
    var requestData = {
        requestContentLocation: $(this).attr("location"),
        requestContentName: $(this).attr("id"),
        requestDomain: domain
    };
    // send reqeust to get content
    processRequest('api/static/content.php', requestData, successCallback, errorCallback);
    // end request to get content

    function successCallback(report) {
        // check if the report contains the api, action, result, message, content
        if(Array.isArray(report) && report.length > 0) {
            // destructure the array and assign keys as variables
            var { api, action, result, message, content } = report[0];

            $("#searchPerspective").html(content);
            $("#searchResultDetails").fadeIn().animate({scrollTop: 0}, 400);
            $("#message").html(message);

        } else {
            console.error("Invalid response format: Missing report data!");
        }
        console.log(report);
    }

    function errorCallback(xhr, status, error) {
        var errorMessage = 'Error occurred while processing the request. Please try again later.';
        console.error('AJAX error:', error);
        $("#searchPerspective").html('<div class="error">' + errorMessage + '</div>');
        $("#message").html('<div class="error">' + errorMessage + '</div>');
        $("#searchResultDetails").fadeIn();
    }

}); // end ajax search result full view content request

// return to search results
$(document).on("click", "#returnToResults", function() {
    $("#searchResultDetails").fadeOut();
});

// toggle search filters
$(document).on("click", "#searchFiltersToggle", function(){
    $("#searchFilters").animate({left: $("#searchFilters").position().left === 0 ? -300 : 0}, 300);
    if ($(this).hasClass("icon-left")) {$("#searchResults").animate({left: 0,width: "100%"}, 300);}
    else {
        var containerWidth = $(window).width(); var searchResultsWidth = containerWidth - 280;
        $("#searchResults").animate({left: "280px",width: searchResultsWidth + "px"}, 300);
    }
    $(this).toggleClass("active icon-left icon-eq-v");
});

// search icon animation
$("#searchInput input").on("focus blur", function() {
    $("#searchInput").toggleClass("icon-radio-button icon-search");
});
