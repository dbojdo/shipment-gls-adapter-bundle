Feature: WebitShipmentGlsAdapterBundle - Service container extension
  In order to bootstrap GLS-ADE and GLS Track & Trace adapter for Web-IT shipment
  As a developer
  I want register GlsAdeShipmentAdapter libraries services in Container

  Scenario: Loading services
    Given application is up
    Then there should be following services in container:
    """
    webit_shipment_gls_adapter.adapter_factory,webit_shipment_gls_adapter.adapter
    """
