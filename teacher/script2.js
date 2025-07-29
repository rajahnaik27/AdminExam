var url2 = "./COA.pdf";
var pdfDoc2 = null,
  pageNum2 = 1,
  pageRendering2 = false,
  pageNumPending2 = null,
  scale = 2,
  canvas2 = document.getElementById("canvas2_Ques"),
  ctx2 = canvas2.getContext("2d");

/**
 * Get page info from document, resize canvas accordingly, and render page.
 * @param num Page number.
 */
function renderPage2(num2) {
  pageRendering2 = true;
  // Using promise to fetch the page
  pdfDoc2.getPage(num2).then(function (page) {
    var viewport = page.getViewport({ scale: scale });
    canvas2.height = viewport.height;
    canvas2.width = viewport.width;

    // Render PDF page into canvas context
    var renderContext2 = {
      canvasContext: ctx2,
      viewport: viewport,
    };
    var renderTask2 = page.render(renderContext2);

    // Wait for rendering to finish
    renderTask2.promise.then(function () {
      pageRendering2 = false;
      if (pageNumPending2 !== null) {
        // New page rendering is pending
        renderPage2(pageNumPending2);
        pageNumPending2 = null;
      }
    });
  });

  // Update page counters
  document.getElementById("page_num2").textContent = num2;
}

function queueRenderPage2(num2) {
  if (pageRendering) {
    pageNumPending2 = num2;
  } else {
    renderPage2(num2);
  }
}

/**
 * Displays previous page.
 */
function onPrevPage2() {
  if (pageNum2 <= 1) {
    return;
  }
  pageNum2--;
  queueRenderPage2(pageNum2);
}
document.getElementById("prev2").addEventListener("click", onPrevPage2);

/**
 * Displays next page.
 */
function onNextPage2() {
  if (pageNum2 >= pdfDoc2.numPages) {
    return;
  }
  pageNum2++;
  queueRenderPage2(pageNum2);
}
document.getElementById("next2").addEventListener("click", onNextPage2);

pdfjsLib.getDocument(url2).promise.then(function (pdfDoc2_) {
  pdfDoc2 = pdfDoc2_;
  document.getElementById("page_count2").textContent = pdfDoc2.numPages;

  // Initial/first page rendering
  renderPage2(pageNum2);
});
