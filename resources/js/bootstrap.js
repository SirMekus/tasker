import { registerEventListeners, on, showSpinner, removeSpinner, showCanvass, insertAfter, DisplayAsToast } from "mmuo"
import * as bootstrap from '~bootstrap';
import axios from 'axios';

window.addEventListener("DOMContentLoaded", function() {
    registerEventListeners()

    document.addEventListener('admin_logout', (event) => {
        location.href=event.detail.data.url
    });

    document.addEventListener('activity_trigger', (response) => {
        location.reload()
    });

    on('.dragger', 'dragstart', function(ev){
        // Add the target element's id to the data transfer object
        ev.dataTransfer.setData("text/plain", ev.target.id);
    })

    on('.dragger', 'dragover', function(ev){
        ev.preventDefault();
        ev.dataTransfer.dropEffect = "move";
    })

    on('.dragger', 'drop', function(ev){
        ev.preventDefault();

        const drop_target_id = ev.currentTarget.id;
        const drop_target_order = document.querySelector(`#${drop_target_id}`).querySelector(".order").value;
 
        // Get the id of the origin/src
        const srcID = ev.dataTransfer.getData("text/plain");

        const srcDom = document.querySelector(`#${srcID}`)

        const targetDom = document.querySelector(`#${drop_target_id}`)
 
        const srcOrder = srcDom.querySelector(".order").value

        if(srcOrder > drop_target_order)
        {
            targetDom.parentNode.insertBefore(srcDom, targetDom)
        }
        else
        {
            insertAfter(srcDom, targetDom)
        }
 
        var i = 0;

        document.querySelectorAll("tbody tr").forEach(function (currentValue, currentIndex, listObj) {
            i += 1;
            listObj[currentIndex].querySelector(".order").value = i
        });

        document.querySelector(".save").classList.remove("d-none");
    })

    on('.save', 'click', function(event){
        event.preventDefault();
        var anchorLink = event.currentTarget;
	
	var linkText = anchorLink.textContent;
	
	var addr = anchorLink.getAttribute("href");
	
	var id = [];
	
	var order = [];

    document.querySelectorAll(".id").forEach(function (currentValue, currentIndex, listObj) {
        id.push(listObj[currentIndex].value);
    });

    document.querySelectorAll(".order").forEach(function (currentValue, currentIndex, listObj) {
        order.push(listObj[currentIndex].value);
    });
	
	var data_to_send = {"id":id, "order":order};

    showSpinner()
    anchorLink.classList.add("disabled-link");
	anchorLink.textContent = "Saving..."

    axios
        .request({
            url: addr,
            data:data_to_send,
            method: 'POST',
            headers: {
              'X-Requested-With': 'XMLHttpRequest'
            },
          })
        .then((response) => {
            var serverResponse = (response.data.msg || (response.data.message?.message || response.data.message)) ?? response.data
            DisplayAsToast(serverResponse)
            anchorLink.textContent = "Saved";
        }).catch((error) => {
            DisplayAsToast(error.response.data.message, false)
        }).then(() => {
            removeSpinner()
            anchorLink.textContent = linkText;
			
            setTimeout(function(){
                anchorLink.classList.add("d-none");
			}, 1200);
        });
    })

    on('.logout-form', 'click', function(event){
        event.preventDefault();
        
        if(document.querySelector(".close-alert")){
            document.querySelector(".close-alert").click(); 
        }

        showSpinner()

        var clickedLink = event.currentTarget;
    
        var href = clickedLink.getAttribute("href");

        axios
        .request({
            url: href,
            method: 'POST',
            headers: {
              'X-Requested-With': 'XMLHttpRequest'
            },
          })
        .then((response) => {
            location.href=response.data.url
        }).catch((error) => {
            showCanvass("<div class='text-danger'>"+error.response.data.message +"</div>")
        }).then(() => {
            removeSpinner()
        });
    })
    
}, false);


try {
window.bootstrap =  bootstrap;
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = axios

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';