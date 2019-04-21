<?php

namespace StudentAssignmentScheduler\Classes;

use PHPUnit\Framework\TestCase;

use \Ds\Vector;

class SpecialEventHistoryTest extends TestCase
{
    protected function setup()
    {
        $this->special_event_history_location = __DIR__ . "/../mocks";
        $this->special_event_history_filename_given_correct_order = "mock_special_event_history_given_correct_order";
        $this->special_event_history_filename_given_wrong_order = "mock_special_event_history_given_wrong_order";
        
        $this->filename_of_special_event_history_given_correct_order = join(DIRECTORY_SEPARATOR, [
            $this->special_event_history_location,
            $this->special_event_history_filename_given_correct_order
        ]);

        $this->filename_of_special_event_history_given_wrong_order = join(DIRECTORY_SEPARATOR, [
            $this->special_event_history_location,
            $this->special_event_history_filename_given_wrong_order
        ]);

    }

    public function testSpecialEventHistoryMaintainsChronologicalOrderOfEvents()
    {
        $jan = new Month(1);
        $feb = new Month(2);
        $mar = new Month(3);
        $dec = new Month(12);

        $year_a = new Year(2018);
        $year_b = new Year(2019);


        $date_a = new Date($jan, new DayOfMonth($jan, 1), $year_a);
        $date_b = new Date($jan, new DayOfMonth($jan, 3), $year_a);
        $date_c = new Date($feb, new DayOfMonth($feb, 1), $year_a);
        $date_d = new Date($mar, new DayOfMonth($mar, 4), $year_a);
        $date_e = new Date($mar, new DayOfMonth($mar, 20), $year_a);
        $date_f = new Date($dec, new DayOfMonth($dec, 2), $year_a);
        $date_g = new Date($dec, new DayOfMonth($dec, 30), $year_a);
        $date_h = new Date($feb, new DayOfMonth($feb, 19), $year_b);
        $date_i = new Date($feb, new DayOfMonth($feb, 23), $year_b);

        $allowed_types = [
            "CO Visit",
            "Regional Convention",
            "Assembly",
            "Memorial"
        ];

        $special_event_type_a = new SpecialEventType($allowed_types, "CO Visit");
        $special_event_type_b = new SpecialEventType($allowed_types, "Assembly");
        $special_event_type_c = new SpecialEventType($allowed_types, "Regional Convention");
        $special_event_type_d = new SpecialEventType($allowed_types, "Memorial");


        [$a, $b, $c, $d, $e, $f, $g, $h, $i] = $events_correct_order = [
            new SpecialEvent(
                $date_a,
                $special_event_type_a
            ),
            new SpecialEvent(
                $date_b,
                $special_event_type_a
            ),
            new SpecialEvent(
                $date_c,
                $special_event_type_c
            ),
            new SpecialEvent(
                $date_d,
                $special_event_type_a
            ),
            new SpecialEvent(
                $date_e,
                $special_event_type_c
            ),
            new SpecialEvent(
                $date_f,
                $special_event_type_b
            ),
            new SpecialEvent(
                $date_g,
                $special_event_type_c
            ),
            new SpecialEvent(
                $date_h,
                $special_event_type_d
            ),
            new SpecialEvent(
                $date_i,
                $special_event_type_a
            )
        ];

        $events_wrong_order = [
            $d, $f, $a, $i, $g, $e, $c, $h, $b
        ];

        // verify that we can compare events
        $this->assertThat(
            [$a, $b],
            $this->logicalNot(
                $this->equalTo(
                    [$b, $a]
                )
            )
        );

        $this->assertThat(
            $events_correct_order,
            $this->logicalNot(
                $this->equalTo(
                    $events_wrong_order
                )
            )
        );

        // verify that we can test chronological order of events
        $this->assertThat(
            $a,
            $this->lessThan(
                $b
            )
        );

        $this->assertThat(
            $c,
            $this->greaterThan(
                $b
            )
        );

        $dates_original_correct_order = (new Vector($events_correct_order))->map(
            function (SpecialEvent $event): string {
                return $event->date();
            }
        )->toArray();

        $dates_original_wrong_order = (new Vector($events_wrong_order))->map(
            function (SpecialEvent $event): string {
                return $event->date();
            }
        )->toArray();

        $dates_wrong_order_sorted = (new \Ds\Vector($events_wrong_order))
            ->map(
                function (SpecialEvent $event): string {
                    return $event->date();
                }
            )
            ->sorted(
                function (string $a, string $b): int {
                    return $a <=> $b;
                }
            )->toArray();

        $this->assertThat(
            $dates_original_wrong_order,
            $this->logicalNot(
                $this->equalTo(
                    $dates_wrong_order_sorted
                )
            )
        );

        $this->assertThat(
            $dates_original_correct_order,
            $this->equalTo(
                $dates_wrong_order_sorted
            )
        );


        $special_event_history_location = new Destination(
            $this->special_event_history_location
        );

        $SpecialEventHistoryGivenCorrectOrder = new SpecialEventHistory(
            $locationOfCorrectOrder = new SpecialEventHistoryLocation(
                $special_event_history_location,
                $this->special_event_history_filename_given_correct_order
            )
        );

        $SpecialEventHistoryGivenWrongOrder = new SpecialEventHistory(
            $locationOfWrongOrder = new SpecialEventHistoryLocation(
                $special_event_history_location,
                $this->special_event_history_filename_given_wrong_order
            )
        );

        $SpecialEventHistoryGivenCorrectOrder
            ->add($a)
            ->add($b)
            ->add($c)
            ->add($d)
            ->add($e)
            ->add($f)
            ->add($g)
            ->add($h)
            ->add($i)
            ->save(
                $this->filename_of_special_event_history_given_correct_order
            );

        $SpecialEventHistoryGivenWrongOrder
            ->add($f)
            ->add($g)
            ->add($b)
            ->add($a)
            ->add($i)
            ->add($d)
            ->add($h)
            ->add($e)
            ->add($c)
            ->save(
                $this->filename_of_special_event_history_given_wrong_order
            );

        $SpecialEventHistoryCorrectOrderAfterSaving = new SpecialEventHistory($locationOfCorrectOrder);
        $SpecialEventHistoryWrongOrderAfterSaving = new SpecialEventHistory($locationOfWrongOrder);

        $asDateString = function (SpecialEvent $event): string {
            return $event->date();
        };

        $dates_from_history_after_saving_that_was_given_correct_order = (new Vector(
            $SpecialEventHistoryCorrectOrderAfterSaving->toArray()
        ))->map($asDateString)->toArray();

        $dates_from_history_after_saving_that_was_given_wrong_order = (new Vector(
            $SpecialEventHistoryWrongOrderAfterSaving->toArray()
        ))->map($asDateString)->toArray();

        $this->assertEquals(
            $dates_from_history_after_saving_that_was_given_correct_order,
            $dates_from_history_after_saving_that_was_given_wrong_order
        );

        $this->assertThat(
            current($dates_from_history_after_saving_that_was_given_wrong_order),
            $this->greaterThan(
                end($dates_from_history_after_saving_that_was_given_wrong_order)
            )
        );
    }

    protected function teardown()
    {
        unlink($this->filename_of_special_event_history_given_correct_order);
        unlink($this->filename_of_special_event_history_given_wrong_order);
    }
}
