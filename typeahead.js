jQuery(document).ready((function() {
    var e = new Bloodhound({
        remote: {
            url: "https://na57vjrdz0.execute-api.eu-west-2.amazonaws.com?name=%QUERY%",
            wildcard: "%QUERY%"
        },
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace("name"),
        queryTokenizer: Bloodhound.tokenizers.whitespace
    });
    jQuery(".search-input").typeahead({
        hint: !0,
        highlight: !0,
        minLength: 2,
        displayKey: "name"
    }, {
        source: e.ttAdapter(),
        name: "coinsList",
        templates: {
            empty: ['<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'],
            header: ['<div class="list-group search-results-dropdown">'],
            pending: '<div class="list-group search-results-dropdown"><div class="list-group-item">Searching...</div></div>',
            suggestion: function(e) {
                return '<span class="list-group-item" data-id="' + e.id + '" class="quick-jump"><img style="float:right; width:42px; height:42px" src="https://www.cryptocompare.com/' + e.image + '"><span><b>' + e.symbol + '</b></span><span style="font-weight: 500;"> ' + e.name + '</span><br><span style="font-weight: 300;">' + e.fullname + "</span></span>"
            }
        },
        display: function(e) {
            return e.name
        }
    }).on("typeahead:opened", (function() {
        $(".tt-dropdown-menu").css("width", "100%")
    }))
})), jQuery(".search-input").bind("typeahead:select", (function(e, t) {
    e.preventDefault(), location.href = "/check/" + t.id
}));