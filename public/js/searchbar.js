function afficheListe() 
            {
                var x = document.getElementById("myUL");
                if (x.style.display === "none") {
                  x.style.display = "block";
                } else {
                  x.style.display = "none";
                }
            } 

            function afficheListekeyboard() 
            {
                var x = document.getElementById("myUL");
                if (x.style.display === "none" && event.keyCode !== 13) {
                  x.style.display = "block";
                }
            }

            function searchFunction() 
            {
                var input, filter, ul, li, a, i, txtValue, path;
                input = document.getElementById("myInput");
                m = 0;
                filter = input.value.toUpperCase();
                ul = document.getElementById("myUL");
                li = ul.getElementsByTagName("li");
                for (i = 0; i < li.length; i++) 
                {   

                    a = li[i].getElementsByClassName("pays")[0];
                    txtValue = a.textContent || a.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) 
                    {
                        li[i].style.display = "";
                        if (event.keyCode === 13) {
                            path = a.getAttribute("href");
                            window.location.href=path;
                        }
                    } else {
                        li[i].style.display = "none";
                    }
                }
            }            

            