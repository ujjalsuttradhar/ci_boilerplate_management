/**
 * @author Ujjal Suttra Dhar <sssujjal@gmail.com>
 */


$(document).ready(function() {
//auto suggestion by typeahead.js
    var users = new Bloodhound({
        datumTokenizer: function(d) {
            return Bloodhound.tokenizers.whitespace(d);
        },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: 'users/getAutoCompleteSuggestion?query=%QUERY',
            filter: function(users) {
                return $.map(users, function(user) {
                    return {
                        value: user.name + ' (' + user.address + ')',
                        id: user.user_id
                    };
                });
            }
        }
    });
    // initialize the bloodhound suggestion engine
    users.initialize();
    // instantiate the typeahead UI
    $('.typeahead').typeahead(null, {
        displayKey: 'value',
        source: users.ttAdapter()
    });


    $('.typeahead').on('typeahead:selected', function(e, users) {
        window.location.href = 'users/profile/' + users.id;
    });

}); //end of ready
