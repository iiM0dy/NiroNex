{{-- § 8  TESTIMONIALS — matches PO Trade reviews section --}}
<section class="hp-reviews">
    <div class="container">
        <div class="text-center mb-4 wow fadeInUp">
            <h2 class="hp-sec-title">أكثر من آلاف المتداولين حول العالم يثقون بنا</h2>
        </div>
        <div class="row g-3 justify-content-center">
            @foreach($testimonialsData as $index => $r)
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay=".{{ $index + 1 }}s">
                <div class="hp-review-card">
                    <div class="hp-review-stars mb-1">
                        @for($i = 0; $i < ($r['stars'] ?? 5); $i++)
                        <i class="fa-solid fa-star"></i>
                        @endfor
                    </div>
                    <p class="hp-review-text">"{{ $r['text'] }}"</p>
                    <div class="hp-review-author">
                        <div class="hp-review-avatar">{{ mb_substr($r['name'], 0, 1) }}</div>
                        <div>
                            <div class="hp-review-name">{{ $r['name'] }}</div>
                            <div class="hp-review-uid">{{ $r['uid'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="hp-review-footer text-center wow fadeInUp">
            <p>ملاحظاتكم تساعدنا في تحسين منصتنا وتقديم أفضل تجربة تداول تناسب احتياجاتكم.</p>
            <a href="#" class="hp-btn-outline mt-2">عرض جميع التقييمات</a>
        </div>
    </div>
</section>
