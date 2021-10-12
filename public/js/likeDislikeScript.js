$(document).ready(main());

function main() {
   let likeButtons = new Array;
   $('*[id*=suggestion-like-]:visible').each(function () {
      likeButtons.push($(this).attr('id'));
   });

   console.log(likeButtons);

   likeButtons.forEach(likeButton => {
      let id = likeButton.split('-')[2];
      attachFunctionToButton(id);
   });
}

function attachFunctionToButton(id) {
   // TODO: why does it need to be an anonymous function?
   $(`#suggestion-like-${id}`).click(function () {
      addLikeButton(id);
   });

   $(`#suggestion-dislike-${id}`).click(function () {
      addDislikeButton(id);
   });
}

function addLikeButton(id) {
   let url = `/suggestionReview/reviewPositive/${id}`;
   $.ajax({
      url: url,
      type: 'GET',
      success: function (data) {
         data = JSON.parse(data);
         refreshLikeCounter(id, data.counter);
         toggleButton('suggestion-like', id, true);
      }
   });
}

function addDislikeButton(id) {
   let url = `/suggestionReview/reviewNegative/${id}`;
   $.ajax({
      url: url,
      type: 'GET',
      success: function (data) {
         data = JSON.parse(data);
         refreshLikeCounter(id, data.counter);
         toggleButton('suggestion-dislike', id, false);
      }
   });
}

function refreshLikeCounter(id, counter) {
   let counterElement = $(`#suggestion-likes-${id}`);
   counterElement.text(parseInt(counter));
}

function toggleButton(buttonName, id, likeButton) {
   let button = $(`#${buttonName}-${id}`);
   if (likeButton) {
      if (button.hasClass('btn-success')) {
         button.removeClass('btn-success');
         button.addClass('btn-primary');         
      }
      else {
         button.addClass('btn-success');
         button.removeClass('btn-primary');
      }

   } else {
      if (button.hasClass('btn-danger')) {
         button.removeClass('btn-danger');
         button.addClass('btn-primary');
      }
      else {
         button.addClass('btn-danger');
         button.removeClass('btn-primary');
      }
   }
   toggleOppositeButton(buttonName, id);
}

function toggleOppositeButton(buttonName, id)
{
   if (buttonName == 'suggestion-like')
   {
      buttonName = 'suggestion-dislike-' + id;
      $(`#${buttonName}`).removeClass('btn-danger');
      $(`#${buttonName}`).addClass('btn-primary');
   }
   else
   {
      buttonName = 'suggestion-like-' + id;
      $(`#${buttonName}`).removeClass('btn-success');
      $(`#${buttonName}`).addClass('btn-primary');
   }
}

