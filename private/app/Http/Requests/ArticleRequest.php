<?php

namespace App\Http\Requests;

use App\Article;
use App\Category;
use App\Tag;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title'    => [ 'required' , 'string' , 'min:18' , 'max:100' , Rule::unique('articles', 'title')->ignore($this->article)],
            'lang'     => [ 'required' , 'string' , 'max:50' ],
            'category' => [ 'required' , 'string' , 'max:50' ],
            'summary'  => [ 'required' , 'string' , 'min:100' , 'max:255' , Rule::unique('articles', 'summary')->ignore($this->article)],
            'content'  => [ 'required' , 'string' , 'min:1000' , Rule::unique('articles', 'content')->ignore($this->article)],
            'upload_featured_image' => [
                'required',
                'mimes:' . get_option('upload_filetypes'),
                'max:' . get_option('fileupload_max'),
            ],
            'seo' => [
                'nullable',
                'array',
            ],
            'seo.keywords' => [ 'required' , 'string' , 'min:250' , 'max:1000' ],
            /*
            'pay_type' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!array_key_exists($value, get_allowed_types())) {
                        return $fail(__('Invalid pay type.'));
                    }
                },
            ],
            'price' => [
                function ($attribute, $value, $fail) use ($data) {
                    $pay_type = (int)$data['pay_type'];

                    // Check if PPA
                    if ($pay_type === 2) {
                        $price = abs(floatval($value));

                        if ($price == 0) {
                            return $fail(__('Invalid price.'));
                        }
                    }
                },
            ],
            */
        ];

        if ($this->route()->getPrefix() === '/admin') {


            // remove required at category 
            unset($rules['category'][0]);
            // remove required at image 
            unset($rules['upload_featured_image'][0]);


            $rules['categories'] = [
                'required',
                'array',
                function ($attribute, $value, $fail) {
                    $categories = Category::where('status', 1)->pluck('id')->toArray();
                    if (array_diff($value, $categories)) {
                        return $fail(__('Invalid categories.'));
                    }
                },
            ];

            $rules['main_category'] = [
                'required',
                function ($attribute, $value, $fail) {
                    if (!in_array($value, $this->post('categories', []))) {
                        return $fail(__('The category marked as main is not on the categories list.'));
                    }
                },
            ];

            $rules['tags'] = [
                'array',
                function ($attribute, $value, $fail) {
                    $tags = Tag::where('status', 1)->pluck('id')->toArray();
                    if (array_diff($value, $tags)) {
                        return $fail(__('Invalid tags.'));
                    }
                },
            ];

            $rules['status'] = ['required'];
            // $rules['user_id'] = ['required'];
        }

        if ($this->route()->getPrefix() === '/member') {
            $rules['category'] = [
                'required',
                function ($attribute, $value, $fail) {
                    $categories = Category::where('status', 1)->pluck('id')->toArray();
                    if (!in_array($value, $categories)) {
                        return $fail(__('Invalid category.'));
                    }
                },
            ];

            if ($this->route()->getName() === 'member.articles.update') {
                // Remove 'required' when editing articles
                // unset($rules['category'][0]);
                // unset($rules['summary'][0]);
                unset($rules['content']);
                unset($rules['upload_featured_image']);
            }

            // $rules['reason'] = ['required'];
        }

        return $rules;
    }

    protected function prepareForValidation()
    {
        $article = $this->route('article');

        $data = $this->only([
            'title',
            'slug',
            'summary',
            'content',
            'read_time',
        ]);

        if (isset($data['slug']) && !empty($data['slug'])) {
            $data['slug'] = Article::createSlug(Article::class, $data['slug'], ($article->id ?? null));
        } else {
            $data['slug'] = Article::createSlug(Article::class, $data['title'], ($article->id ?? null));
        }

        $data['summary'] = Article::purifyStripHtml($data['summary']);
        $data['content'] = Article::purify($data['content']);

        // if (empty($data['read_time'])) {
        //     // https://blog.medium.com/read-time-and-you-bc2048ab620c
        //     $article_words = explode(' ', Article::purifyStripHtml($data['content']));
        //     $article_words = array_filter($article_words, function ($word) {
        //         return mb_strlen($word) > 3;
        //     });
        //     $data['read_time'] = floor((count($article_words) / 275) * 60); // In Seconds
        // }

        // Fixed read_time at 30 sec at all 
        $data['read_time'] = 30;

        $this->merge($data);
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //'title.required' => __('A title is required'),
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'upload_featured_image' => 'image',
        ];
    }
}
