<?php


class PageDraftTest extends TestCase
{
    protected $page;
    protected $pageRepo;

    public function setUp()
    {
        parent::setUp();
        $this->page = \BookStack\Page::first();
        $this->pageRepo = app('\BookStack\Repos\PageRepo');
    }

    public function test_draft_content_shows_if_available()
    {
        $addedContent = '<p>test message content</p>';
        $this->asAdmin()->visit($this->page->getUrl() . '/edit')
            ->dontSeeInField('html', $addedContent);

        $newContent = $this->page->html . $addedContent;
        $this->pageRepo->saveUpdateDraft($this->page, ['html' => $newContent]);
        $this->asAdmin()->visit($this->page->getUrl() . '/edit')
            ->seeInField('html', $newContent);
    }

    public function test_draft_not_visible_by_others()
    {
        $addedContent = '<p>test message content</p>';
        $this->asAdmin()->visit($this->page->getUrl() . '/edit')
            ->dontSeeInField('html', $addedContent);

        $newContent = $this->page->html . $addedContent;
        $newUser = $this->getNewUser();
        $this->pageRepo->saveUpdateDraft($this->page, ['html' => $newContent]);
        $this->actingAs($newUser)->visit($this->page->getUrl() . '/edit')
            ->dontSeeInField('html', $newContent);
    }

    public function test_alert_message_shows_if_editing_draft()
    {
        $this->asAdmin();
        $this->pageRepo->saveUpdateDraft($this->page, ['html' => 'test content']);
        $this->asAdmin()->visit($this->page->getUrl() . '/edit')
            ->see('You are currently editing a draft');
    }

    public function test_alert_message_shows_if_someone_else_editing()
    {
        $nonEditedPage = \BookStack\Page::take(10)->get()->last();
        $addedContent = '<p>test message content</p>';
        $this->asAdmin()->visit($this->page->getUrl() . '/edit')
            ->dontSeeInField('html', $addedContent);

        $newContent = $this->page->html . $addedContent;
        $newUser = $this->getNewUser();
        $this->pageRepo->saveUpdateDraft($this->page, ['html' => $newContent]);

        $this->actingAs($newUser)
            ->visit($this->page->getUrl() . '/edit')
            ->see('Admin has started editing this page');
            $this->flushSession();
        $this->visit($nonEditedPage->getUrl() . '/edit')
            ->dontSeeInElement('.notification', 'Admin has started editing this page');
    }

    public function test_draft_pages_show_on_homepage()
    {
        $book = \BookStack\Book::first();
        $this->asAdmin()->visit('/')
            ->dontSeeInElement('#recent-drafts', 'New Page')
            ->visit($book->getUrl() . '/page/create')
            ->visit('/')
            ->seeInElement('#recent-drafts', 'New Page');
    }

    public function test_draft_pages_not_visible_by_others()
    {
        $book = \BookStack\Book::first();
        $chapter = $book->chapters->first();
        $newUser = $this->getNewUser();

        $this->actingAs($newUser)->visit('/')
            ->visit($book->getUrl() . '/page/create')
            ->visit($chapter->getUrl() . '/create-page')
            ->visit($book->getUrl())
            ->seeInElement('.page-list', 'New Page');

        $this->asAdmin()
            ->visit($book->getUrl())
            ->dontSeeInElement('.page-list', 'New Page')
            ->visit($chapter->getUrl())
            ->dontSeeInElement('.page-list', 'New Page');
    }

}
