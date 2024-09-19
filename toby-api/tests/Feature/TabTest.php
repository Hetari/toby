<?php

namespace Tests\Feature;

use App\Models\Collection;
use App\Models\Tab;
use Tests\TestCase;
use Illuminate\Http\Response;
use PHPUnit\Framework\Attributes\Test;

class TabTest extends TestCase
{
    #[Test]
    public function tab_belongs_to_collection()
    {
        // Create a collection using factory
        $collection = Collection::factory()->create();

        // Create a tab associated with the collection
        $tab = Tab::factory()->create([
            'collection_id' => $collection->id,
        ]);

        // Assert the relationship works (belongsTo)
        $this->assertInstanceOf(Collection::class, $tab->collection);
        $this->assertEquals($collection->id, $tab->collection->id);
    }

    #[Test]
    public function tab_has_fillable_attributes()
    {
        // Create a Tab using factory with custom data
        $data = [
            'title' => 'Example Tab',
            'url' => 'https://example.com',
            'collection_id' => 1,
        ];

        $tab = Tab::create($data);

        // Check that the attributes were properly set
        $this->assertEquals('Example Tab', $tab->title);
        $this->assertEquals('https://example.com', $tab->url);
        $this->assertEquals(1, $tab->collection_id);
    }

    #[Test]
    public function tab_has_searchable_attributes()
    {
        // Create a Tab using factory
        $tab = Tab::factory()->create([
            'title' => 'Searchable Tab',
        ]);

        // Call the toSearchableArray method
        $searchableArray = $tab->toSearchableArray();

        // Check that the array contains the correct data
        $this->assertArrayHasKey('title', $searchableArray);
        $this->assertEquals('Searchable Tab', $searchableArray['title']);
    }

    #[Test]
    public function tab_without_collection_id_fails()
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        // Attempt to create a Tab without a collection_id
        Tab::factory()->create([
            'collection_id' => null,
        ]);
    }
}
