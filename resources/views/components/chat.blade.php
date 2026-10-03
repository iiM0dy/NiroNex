 <div class="container-xxl p-0">
     <div class="row g-0">
         <div class="col-12 d-flex">

             <!-- Card: -->
             <div class="card card-chat-body shadow-sm  w-100 px-4 px-md-5 py-3 py-md-4">

                 <!-- Chat: Header -->
                 <div class="chat-header d-flex justify-content-between align-items-center border-bottom pb-3">
                     <div class="d-flex align-items-center">
                         <a href="javascript:void(0);" title="">
                             <img class="avatar rounded" src="{!! backendAssets('dist/assets/images/sm/avatar1.svg') !!}" alt="avatar">
                         </a>
                         <div class="ms-3">
                             <h6 class="mb-1">الدعم الفني</h6>
                             <small class="text-muted">رد سريع، حل أكيد، وراحة مضمونـة!</small>
                         </div>
                     </div>
                 </div>

                 <!-- Chat: body -->
                 <ul class="chat-history list-unstyled mb-0 py-lg-5 py-md-4 py-3 flex-grow-1">
                     <!-- Chat: User -->
                     <li class="mb-3 d-flex flex-row align-items-end">
                         <div class="max-width-70">
                             <div class="user-info mb-1">
                                 <img class="avatar sm rounded-circle me-1"
                                     src="{{ auth()->user()->getStorageUrl(auth()->user()->image) ?? backendAssets('dist/assets/images/xs/avatar2.svg') }}"
                                     alt="avatar">
                                 <span class="text-muted small">10:10 AM, Today</span>
                             </div>
                             <div class="card border-0 p-3">
                                 <div class="message"> Hi Aiden, how are you?</div>
                             </div>
                         </div>
                     </li>
                     <!-- Chat: Admin -->
                     <li class="mb-3 d-flex flex-row-reverse align-items-end text-start">
                         <div class="max-width-70 text-right">
                             <div class="user-info mb-1">
                                 <span class="text-muted small">10:12 AM, Today</span>
                             </div>
                             <div class="card border-0 p-3 bg-primary text-light">
                                 <div class="message">Fine</div>
                             </div>
                         </div>
                     </li>
                 </ul>

                 <!-- Chat: Footer -->
                 <div class="chat-message" style="display: flex; gap: 10px; align-items: center; padding: 10px;">
                     <input class="form-control" placeholder="Enter text here..." style="flex: 1;" />
                     <button class="btn btn-primary rounded fs-3" style="height: 44px;">
                         <i class="icofont-paper-plane"></i>
                     </button>
                 </div>

             </div>
         </div>
     </div> <!-- row end -->
 </div>
