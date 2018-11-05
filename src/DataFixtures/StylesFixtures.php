<?php
/**
 * @author Bartłomiej Olewiński <bartlomiej.olewinski@gmail.com>
 */

namespace App\DataFixtures;

use App\Entity\Style;
use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class StylesFixtures extends Fixture
{

    /**
     * @var ObjectManager
     */
    protected $em;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->em =  $manager;

        $this->addStyle(
            '2e6c0330-bb8a-4560-aa42-ad49397ad236',
            'Nano Hair-strokes: Full Brow',
            ['Eyebrows','brows','perfectbrows','microblading','nanoblading','Permanentmakeup'],
            'Full brow hair-stroke application = maximum volume, definition, and symmetry.',
            '2018-08-18 22:01:31',
            Style::STATUS_PUBLISHED
        );

        $this->addStyle(
            '725eb4f4-7601-478b-afad-310a700672c8',
            'Rainbow',
            ['nailart','rainbow','gelnailart'],
            'Mica gave me rainbow tips! I love them. I\'m on the way to AFROPUNK Brooklyn !!',
            '2018-08-20 18:03:09',
            Style::STATUS_PUBLISHED
        );

        $this->addStyle(
            '748859ee-5550-4b5c-8c54-226d45dca6b2',
            'GOLD PUNK',
            ['nailart','gelnailart','foils','gold','black'],
            'I\'m going AFROPUNK and wanted punk with a bit of glam !!',
            '2018-08-20 18:15:20',
            Style::STATUS_PUBLISHED
        );

        $this->addStyle(
            'aa44e7b2-170e-4a6b-a097-38ea910618de',
            'Choppy Lob',
            ['Shizen','Brooklyn'],
            'Got four inches of dead summer hair hacked off. Super fast and exactly what I asked for! Amazing head massage too.',
            '2018-08-20 22:54:19',
            Style::STATUS_DRAFT
        );

        $this->addStyle(
            '0ea56a80-2e3c-40b1-b994-70f4f51875bd',
            'Nano Hair-strokes: Full Brow',
            ['Eyebrows','brows','perfectbrows','microblading','nanoblading','Permanentmakeup'],
            'Full brow hair-stroke application = maximum volume, definition, and symmetry.',
            '2018-08-18 22:01:18',
            Style::STATUS_PUBLISHED
        );

        $this->addStyle(
            '9961c958-15cd-446d-b53e-c0d9aaed4bf5',
            'Nano Hair-strokes: Full Brow',
            ['Eyebrows','brows','perfectbrows','microblading','nanoblading','Permanentmakeup'],
            'Full brow hair-stroke application = maximum volume, definition, and symmetry.',
            '2018-08-18 22:01:31',
            Style::STATUS_PUBLISHED,
            true
        );
    }

    /**
     * @param string $guid
     * @param string $name
     * @param array $tags
     * @param string $description
     * @param string $datetime
     * @param string $status
     * @param bool $deleted
     */
    protected function addStyle(string $guid, string $name, array $tags, string $description, string $datetime, string $status, bool $deleted = false)
    {
        $style = new Style();
        $style->setGuid($guid);
        $style->setName($name);
        foreach ($tags as $tag) {
            $style->addTag($this->getTag($tag));
        }
        $style->setDescription($description);
        $style->setDateCreated(new \DateTime($datetime));
        $style->setStatus($status);
        $style->setDeleted($deleted);
        $this->em->persist($style);
        $this->em->flush();
    }

    /**
     * @param string $tag
     * @return Tag|null|object
     */
    protected function getTag(string $tag)
    {
        return $this->em->getRepository(Tag::class)->findOneBy(['tag' => $tag]) ?? new Tag($tag);
    }
}
