/**
 * Created by Dev1 on 10/3/2016.
 */

$(function(){
    $('.magnificPopup').magnificPopup();
    // Permissions Class
    var Permissions = new function(){
        var object = {}, container, html;

        // Getting Json object from element attribute
        this.getObject = function(elem){
            object = JSON.parse($(elem).attr('data-permissions'));
            return this;
        };

        // Pushing  Object values to div
        this.pushToDiv = function(div_class){
            container = $(div_class);
            html = '';
            $.each(object, function(perm_name, perm_group){
                html += '<div class="permissionPopup">';
                html += '<p class="pHeader">'+roles['headers'][perm_name]+'</p>';
                html += '<ul class="pBody">';
                $.each(perm_group, function(key, name){
                    html += '<li>'+ name +'</li>';
                });
                html += '</ul>';
                html += '</div>';
            });
            container.empty();
            container.append(html);
            return this;
        };
    };

    $('.rolesExpand').click(function(){
        Permissions.getObject(this).pushToDiv('.permissionsPopup');
    });
});