"use strict";

$(document).ready(function () {
    const draggables = document.querySelectorAll(".task");
    const droppables = document.querySelectorAll(".swim-lane");
    let bottomTask = null;
    let curTask = null;
    let zone_original = null;
    let zone_new = null;

    droppables.forEach((zone) => {
      zone.addEventListener("dragover", (e) => {
        e.preventDefault();

        bottomTask = insertAboveTask(zone, e.clientY);
        curTask = document.querySelector(".is-dragging");
        
        if (!bottomTask) {
          zone.appendChild(curTask);
        } else {
          zone.insertBefore(curTask, bottomTask);
        }

        zone_new = zone;

      });

      zone_original = zone;
    });

    draggables.forEach((task) => {
      task.addEventListener("dragstart", () => {
        // console.log('drag-start');
        task.classList.add("is-dragging");
      });
      task.addEventListener("dragend", () => {
        console.log(task.id);
        console.log(zone_original);
        console.log(zone_new.id);
        console.log(curTask);
        console.log(bottomTask);

        if(bottomTask) {
          var bottomId = bottomTask.id;
        } else {
          var bottomId = 0;
        }

        $.get("/mytasks/move/" + task.id + "/" + zone_new.id + "/" + bottomId, function(res) {
            
            console.log('success');
            document.getElementById('status0').innerHTML = res.status0;
            document.getElementById('status1').innerHTML = res.status1;
            document.getElementById('status2').innerHTML = res.status2;
            document.getElementById('status3').innerHTML = res.status3;

            !(function(o, t) {
              o.Toast("Update Task Successfully!", "success", {
                  position: "top-right",
                  timeOut: "2000",
              });
            })(NioApp, jQuery);

        });

        task.classList.remove("is-dragging");
      });
    });


    const insertAboveTask = (zone, mouseY) => {
      const els = zone.querySelectorAll(".task:not(.is-dragging)");

      let closestTask = null;
      let closestOffset = Number.NEGATIVE_INFINITY;

      els.forEach((task) => {
        const { top } = task.getBoundingClientRect();

        const offset = mouseY - top;

        if (offset < 0 && offset > closestOffset) {
          closestOffset = offset;
          closestTask = task;
        }
      });

    //   console.log('insertAboveTask');

      return closestTask;
    };


    // const form = document.getElementById("todo-form");
    // const input = document.getElementById("todo-input");
    // const todoLane = document.getElementById("todo-lane");

    // form.addEventListener("submit", (e) => {
    //   e.preventDefault();
    //   const value = input.value;

    //   if (!value) return;

    //   const newTask = document.createElement("p");
    //   newTask.classList.add("task");
    //   newTask.setAttribute("draggable", "true");
    //   newTask.innerText = value;

    //   newTask.addEventListener("dragstart", () => {
    //     newTask.classList.add("is-dragging");
    //   });

    //   newTask.addEventListener("dragend", () => {
    //     newTask.classList.remove("is-dragging");
    //   });

    //   todoLane.appendChild(newTask);

    //   input.value = "";
    // });
});